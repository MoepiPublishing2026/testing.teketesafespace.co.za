<?php

namespace App\Support;

use RuntimeException;

class LegacyUploadBackup
{
    public function directory(?string $requested): string
    {
        $directory = $requested ?? storage_path('app/private/legacy-upload-backups');

        if ($requested === null && ! is_dir($directory)
            && ! @mkdir($directory, 0700, true) && ! is_dir($directory)) {
            throw new RuntimeException('Could not create the private backup directory.');
        }

        $root = realpath($directory);
        if ($root === false || ! is_dir($root) || ! is_writable($root)) {
            throw new RuntimeException('The backup destination must be an existing writable directory.');
        }

        foreach ([public_path(), base_path('public'), base_path('public_html'), storage_path('app/public')] as $public) {
            $canonical = realpath($public);
            if ($canonical !== false && ($root === $canonical || str_starts_with($root, $canonical.DIRECTORY_SEPARATOR))) {
                throw new RuntimeException('The backup destination must be outside public upload directories.');
            }
        }

        return $root;
    }

    public function copy(string $root, string $source): ?string
    {
        $digest = @hash_file('sha256', $source);
        if ($digest === false) {
            return null;
        }

        // The digest separates same-named files with different bytes.
        $directory = $root.DIRECTORY_SEPARATOR.$digest.'-'.hash('sha256', $source);
        if (! is_dir($directory) && ! @mkdir($directory, 0700) && ! is_dir($directory)) {
            return null;
        }
        if (is_link($directory) || realpath($directory) !== $directory) {
            return null;
        }

        $metadata = $directory.DIRECTORY_SEPARATOR.'origin.json';
        $origin = json_encode(['path' => $source, 'sha256' => $digest], JSON_THROW_ON_ERROR);
        if (is_link($metadata)) {
            return null;
        }
        if (! is_file($metadata)) {
            $manifest = @fopen($metadata, 'xb');
            if ($manifest === false) {
                return null;
            }
            $saved = @chmod($metadata, 0600) && fwrite($manifest, $origin) === strlen($origin) && fflush($manifest);
            fclose($manifest);
            if (! $saved) {
                @unlink($metadata);

                return null;
            }
        }
        if (@file_get_contents($metadata) !== $origin) {
            return null;
        }

        $target = $directory.DIRECTORY_SEPARATOR.'original';
        if (is_link($target)) {
            return null;
        }
        if (is_file($target)) {
            return $this->matches($source, $target, $digest) ? $target : null;
        }

        $input = @fopen($source, 'rb');
        if ($input === false) {
            return null;
        }
        $output = @fopen($target, 'xb');
        if ($output === false) {
            fclose($input);

            return null;
        }

        $copied = @chmod($target, 0600) && stream_copy_to_stream($input, $output) !== false && fflush($output);
        fclose($input);
        fclose($output);

        if (! $copied || ! $this->matches($source, $target, $digest)) {
            @unlink($target);

            return null;
        }

        return $target;
    }

    public function removeOriginal(string $source, string $backup): bool
    {
        $metadata = dirname($backup).DIRECTORY_SEPARATOR.'origin.json';
        $digest = substr(basename(dirname($backup)), 0, 64);
        $expected = json_encode(['path' => $source, 'sha256' => $digest], JSON_THROW_ON_ERROR);

        return ! is_link($source) && ! is_link($metadata) && @file_get_contents($metadata) === $expected
            && $this->matches($source, $backup, $digest) && @unlink($source);
    }

    private function matches(string $source, string $target, string $digest): bool
    {
        return ! is_link($target) && @hash_file('sha256', $source) === $digest
            && @hash_file('sha256', $target) === $digest;
    }
}
