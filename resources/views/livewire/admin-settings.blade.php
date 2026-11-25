
<section>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');

.font-montserrat-bold,
.font-montserrat-regular,
.font-montserrat-black {
    font-family: 'Montserrat', sans-serif !important;
}

.sidebar {
    width: 155px !important;
    flex-shrink: 0;
    background: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 110px !important;
}

.sidebar-list {
    list-style: none;
    padding-left: 15px !important;
}

.sidebar-link {
    display: block;
    width: 92%;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 6px 9px !important;
    margin-bottom: 10px !important;
    border-radius: 8px;
    text-decoration: none;
}

.sidebar-link:hover,
.sidebar-link.active {
    background: #38b6ff !important;
    color: white !important;
}

.main-panel {
    flex: 1;
    min-width: 0;
    height: 100vh;
    background: white;
}

#main-content {
    padding: 0 16px 18px !important;
    margin-top: 0 !important;
    overflow-y: auto;
    background: white;
}

/* Page heading */
.profile-header {
    max-width: 645px;
    height: 106px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.profile-header h1 {
    font-size: 18px !important;
    font-weight: 800 !important;
    color: #545454 !important;
    margin: 0 !important;
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: right;
    font-size: 12px;
    line-height: 1.4;
}

.admin-info strong {
    display: block;
    color: #38b6ff;
    font-weight: 700;
}

.admin-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #e3e7ec;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

/* Profile card */
.profile-card {
    width: 100%;
    max-width: 645px;
    min-height: 684px;
    padding: 18px 26px 35px !important;
    margin-top: 16px;
    border: 2px solid #c7da30 !important;
    border-radius: 6px !important;
    background: white;
    box-shadow: none !important;
}

.profile-intro {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
}

.profile-picture {
    width: 128px !important;
    height: 128px !important;
    border-radius: 50% !important;
    object-fit: cover;
    border: none !important;
}

.profile-placeholder {
    width: 128px;
    height: 128px;
    border-radius: 50%;
    background: #e3e7ec;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-intro p {
    color: #4b5563;
    font-size: 13px;
    margin-bottom: 8px;
}

.choose-file-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 195px !important;
    height: 35px !important;
    box-sizing: border-box !important;
    padding: 5px 10px;
    border: none;
    border-radius: 8px;
    background: #38b6ff;
    color: white !important;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    transition: 0.2s;
}

.choose-file-button:hover {
    background: #219fe8;
    color: white !important;
}
/* Input fields */
.form-field {
    margin-bottom: 5px;
}

.form-field label,
.password-field label {
    display: block;
    margin-bottom: 4px;
    color: #4b5563;
    font-size: 13px;
    font-weight: 700;
}

.form-field input,
.password-field input {
    width: 100%;
    height: 39px;
    padding: 6px 10px;
    border: 2px solid #c7da30 !important;
    border-radius: 7px !important;
    font-size: 13px;
    background: white;
    outline: none;
}

/* Password section */
.password-heading {
    margin: 24px 0 8px;
    color: #545454;
    font-size: 20px;
    font-weight: 700;
    text-align: center;
}

.password-field {
    margin-bottom: 5px;
}

/* Update button */
.profile-update-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 156px;
    margin: 44px auto 0;
    padding: 5px 18px;
    border: none !important;
    border-radius: 8px;
    background: #38b6ff !important;
    color: white !important;
    font-family: 'Montserrat', sans-serif;
    font-size: 12px;
    font-weight: 600;
    box-shadow: none !important;
    cursor: pointer;
}

.profile-update-button:hover {
    background: #219fe8 !important;
    color: white !important;
}

@media (max-width: 900px) {
    .sidebar {
        position: fixed;
        left: 0;
        width: 0 !important;
        overflow-x: hidden;
        z-index: 1000;
    }

    .sidebar.open {
        width: 220px !important;
    }

    #main-content {
        padding: 0 12px 16px !important;
    }

    .profile-card {
        min-height: 0;
        padding: 16px !important;
    }

    .profile-header {
        height: 82px;
    }
}

@media (max-width: 480px) {
    .profile-header h1 {
        font-size: 16px !important;
    }

    .admin-info {
        font-size: 10px;
        gap: 6px;
    }

    .admin-avatar {
        width: 36px;
        height: 36px;
    }

    .profile-intro {
        gap: 12px;
    }

    .profile-picture,
    .profile-placeholder {
        width: 90px !important;
        height: 90px !important;
    }
}


html,
body {
    width: 100%;
    min-height: 100%;
    height: auto !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;
}

/* Main page wrapper */
.flex.min-h-screen {
    min-height: 100vh !important;
    height: auto !important;
    align-items: stretch;
}

/* Main content panel */
.main-panel {
    flex: 1;
    min-width: 0;
    min-height: 100vh !important;
    height: auto !important;
    overflow: visible !important;
    display: flex;
    flex-direction: column;
}


#main-content {
    flex: 1;
    width: 100%;
    min-height: 100vh !important;
    height: auto !important;
    overflow: visible !important;
    padding-bottom: 50px !important;
    margin-top: 0 !important;
}

/* Profile card must not be clipped */
.profile-card {
    min-height: 684px;
    height: auto !important;
    overflow: visible !important;
    margin-bottom: 0;
}

/* Keep the Update button visible below the card */
.profile-update-button {
    margin: 44px auto 40px !important;
}

/* Mobile scrolling */
@media (max-width: 900px) {
    .main-panel {
        height: auto !important;
        overflow: visible !important;
    }

    #main-content {
        height: auto !important;
        overflow: visible !important;
    }
}



.main-panel {
    flex: 1 !important;
    width: calc(100% - 283px) !important;
    min-width: 0 !important;
    height: auto !important;
    overflow: visible !important;
}

#main-content {
    width: 100% !important;
    max-width: none !important;
    padding: 0 20px 50px !important;
    overflow: visible !important;
    box-sizing: border-box !important;
}

/* Expand heading across the page */
.profile-header {
    width: 100% !important;
    max-width: none !important;
}

/* Expand the form */
#main-content form {
    width: 100% !important;
    max-width: none !important;
    display: block !important;
}

/* Expand the bordered profile card */
.profile-card {
    width: 100% !important;
    max-width: none !important;
    min-height: 684px;
    height: auto !important;
    box-sizing: border-box !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* Keep input fields filling the card */
.profile-card .form-field,
.profile-card .password-field {
    width: 100% !important;
}

.profile-card input {
    width: 100% !important;
    box-sizing: border-box !important;
}

/* Centre the Update button */
.profile-update-button {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    width: 156px !important;
    margin: 44px auto 40px !important;
    text-align: center !important;
}

/* Responsive layout */
@media (max-width: 900px) {
    .main-panel {
        width: 100% !important;
    }

    #main-content {
        padding: 15px !important;
    }

    .profile-card {
        width: 100% !important;
    }
}
.delete-picture-button {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 195px !important;
    height: 35px !important;
    box-sizing: border-box !important;
    padding: 5px 10px !important;
    margin-top: 10px !important;
    border: none !important;
    border-radius: 8px !important;
    background: #ef4444 !important;
    color: white !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    cursor: pointer;
}
</style>

@include('components.school-admin-styles')

<div class="flex min-h-screen m-0 p-0" style="min-height:100vh;">

    @include('components.school-admin-sidebar')

    <div class="main-panel">

        <main id="main-content" class="flex-1 overflow-auto">

            <!-- Page heading -->
            <div class="profile-header">

                <h1>MY PROFILE</h1>

                <div class="admin-info">
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>Administrator</span>
                    </div>

                    <div class="admin-avatar">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ Auth::user()->profile_picture_url }}"
                                 alt="Profile Picture"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <svg viewBox="0 0 52 52" width="44" height="44">
                                <circle cx="26" cy="26" r="26" fill="#e3e7ec"/>
                                <ellipse cx="26" cy="20" rx="10" ry="12" fill="#566174"/>
                                <path d="M8 47c2-11 9-17 18-17s16 6 18 17c-5 3-11 5-18 5S13 50 8 47Z"
                                      fill="#566174"/>
                            </svg>
                        @endif
                    </div>
                </div>

            </div>

            @if(session()->has('success_message'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success_message') }}
                </div>
            @endif

            <!-- Form -->
            <form wire:submit.prevent="updateSettings" enctype="multipart/form-data">

                <!-- Profile card -->
                <div class="profile-card">

                    <!-- Profile picture -->
                    <div class="profile-intro">

                        <div class="flex-shrink-0">

                            <div wire:loading wire:target="profile_picture"
                                 class="profile-placeholder">

                                <svg class="animate-spin h-10 w-10 text-gray-500"
                                     fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"/>
                                </svg>

                            </div>

                            @if($profile_picture)

                                <img wire:loading.remove
                                     wire:target="profile_picture"
                                     src="{{ $profile_picture->temporaryUrl() }}"
                                     class="profile-picture"
                                     alt="Profile Preview">

                            @elseif(auth()->user()->profile_picture)

                                <img wire:loading.remove
                                     wire:target="profile_picture"
                                     src="{{ auth()->user()->profile_picture_url }}"
                                     class="profile-picture"
                                     alt="Profile Picture">

                            @else

                                <div wire:loading.remove
                                     wire:target="profile_picture"
                                     class="profile-placeholder">

                                    <svg class="w-20 h-20 text-gray-500"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                              clip-rule="evenodd"/>
                                    </svg>

                                </div>

                            @endif

                        </div>

                        <div class="flex flex-col">

                            <p>Update Profile Picture</p>

                            <label class="inline-block w-48">

                                <span class="sr-only">Choose profile photo</span>

                                <input type="file"
                                       wire:model="profile_picture"
                                       class="hidden"
                                       id="profile-picture-input"
                                       accept="image/*">

                                <span class="choose-file-button"
                                      onclick="document.getElementById('profile-picture-input').click()">
                                    Choose File
                                </span>

                            </label>

                            @if(auth()->user()->profile_picture || $profile_picture)

                                <button type="button"
                                 wire:click="deleteProfilePicture"
                                 class="delete-picture-button">
                                Delete Picture
                                </button>

                            @endif

                            <div wire:loading wire:target="profile_picture"
                                 class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>

                            @if($profile_picture)
                                <p class="text-sm text-green-600 mt-2">
                                    File selected: {{ $profile_picture->getClientOriginalName() }}
                                </p>
                            @endif

                            @error('profile_picture')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    <!-- Full Name -->
                    <div class="form-field">

                        <label>Full Name</label>

                        <input type="text"
                               wire:model.defer="Full_name"
                               placeholder="Your full name"
                               pattern="[A-Za-z ]+"
                               title="Only letters and spaces are allowed">

                        @error('Full_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <!-- Email Address -->
                    <div class="form-field">

                        <label>Email Address</label>

                        <input type="email"
                               wire:model.defer="email"
                               placeholder="Email@Address"
                               readonly>

                        @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <!-- Phone Number -->
                    <div class="form-field">

                        <label>Phone Number</label>

                        <input type="text"
                               wire:model.defer="phone_number"
                               placeholder="0000000000">

                        @error('phone_number')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <!-- Update Password -->
                    <h3 class="password-heading">Update Password</h3>

                    <div class="password-field">

                        <label>Old Password</label>

                        <input type="password"
                               wire:model.defer="current_password">

                        @error('current_password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="password-field">

                        <label>New Password</label>

                        <input type="password"
                               wire:model.defer="new_password">

                        @error('new_password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="password-field">

                        <label>Confirm Password</label>

                        <input type="password"
                               wire:model.defer="confirm_password">

                        @error('confirm_password')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                </div>

                <!-- Update button outside the card -->
                <div class="flex justify-center">

                    <button type="submit" class="profile-update-button">

                        <svg wire:loading
                             wire:target="updateSettings"
                             class="animate-spin mr-2 h-4 w-4"
                             fill="none" viewBox="0 0 24 24">

                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"/>

                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>

                        </svg>

                        Update

                    </button>

                </div>

            </form>

        </main>

    </div>

</div>

@include('components.school-admin-sidebar-script')

<script src="https://kit.fontawesome.com/2c36e9b7b9.js"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</section>
