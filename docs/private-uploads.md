# Private staff profile pictures

Staff profile pictures are stored under `avatars/` on the private `attachments` disk. The `avatars.show` endpoint requires authentication and OTP verification, and only returns the signed-in user's own image. Views must use `profile_picture_url`; do not generate public storage URLs for profile pictures.

After deploying this change to an installation with existing public profile pictures, inspect and migrate them before removing old files:

1. Run `php artisan avatars:migrate-legacy --dry-run` and review the users and files.
2. Run `php artisan avatars:migrate-legacy` to copy validated images to private storage, update database paths, and remove detected public copies. Use `--keep-originals` only when intentionally retaining a backup; those copies remain publicly reachable.
3. Run `php artisan uploads:verify` and resolve any reported missing files or public leftovers.

The migration does not rewrite Git history. Previously committed upload blobs must be purged from every relevant local and remote history separately; coordinate any eventual remote history rewrite with repository owners.
