<x-app-layout>
    <script src="{{ URL::asset('js/history.js') }}"></script>
    <script>
        var stateThumbnailDir = "{{ URL::asset('storage/thumbnails/folders') }}/"
    </script>
    @auth
    <script>var user = true;</script>
    @else
    <script>var user = false;</script>
    @endauth
    <main class="p-6 flex gap-6 flex-row-reverse flex-wrap-reverse lg:flex-nowrap snap-y">
        <section id="right-card" class="w-full lg:w-72 shrink-0 hidden lg:block"></section>
        <section id="content-card" class=" dark:bg-neutral-900 shadow-xl p-6 pt-3 rounded-2xl light-mode w-full">
            <nav id="navbar">
                <div class="flex p-1 gap-y-3 flex-wrap justify-between">
                    <h1 id="title" class="text-2xl">Full User History</h1>
                    <span class="flex flex-wrap sm:flex-nowrap sm:max-w-sm items-center gap-2  sm:shrink-0">
                        <section id="user_options" class="group inline-block relative" data-dropdown-toggle="user_dropdown" aria-haspopup="true">
                            <button id="user_header" class="flex space-x-2 text-2xl text-slate-900 dark:text-white hover:text-orange-600 dark:hover:text-orange-600 items-center justify-center" >
                                @auth
                                <span id="user_name">{{ Auth::user()->name }}</span>
                                @else
                                <span id="user_name_unauth" class="w-[10vw] text-right">Guest</span>
                                @endauth

                                <img src="{{ URL::asset('storage/avatars/12345.jpg')}}" class="h-7 w-7 rounded-full sm:mx-0 sm:shrink-0 ring-2 ring-orange-600/60 shadow-lg object-cover" alt="profile picture">
                            </button>    
                            <div role="menu" id="user_dropdown" aria-orientation="vertical" aria-labelledby="user_options" class="hidden absolute left-0 z-30 mt-4 w-56 origin-top-right divide-y divide-gray-300 rounded-md shadow-lg ring-1 bg-white ring-black ring-opacity-5 focus:outline-none text-gray-700">
                                
                                @auth
                                <!-- <div class="divide-y divide-gray-300" role="menu" id="user-menu-auth"> -->
                                <section class="flex flex-wrap gap-1 p-4 justify-between">
                                    <p class="text-sm leading-5 text-orange-500">Logged in as: </p>
                                    <p class="text-sm font-medium leading-5 text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </section>
                                <section class="py-1">
                                    <button class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">Account settings</button>
                                    <button class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">Collections</button>
                                    <button class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem">Dashboard</button>
                                    <button class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left font-bold" role="menuitem">Full History</button>
                                    <button class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem"><a href="/jobs/indexFiles" class="w-full h-full">Index Files</a></button>
                                    <span role="menuitem" tabindex="-1" class="flex justify-between w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 cursor-not-allowed opacity-50" aria-disabled="true">New feature (soon)</span>
                                </section>
                                <section class="py-1">
                                    <button class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" onclick="logout();" role="menuitem">Log out</button>
                                </section>
                                <!-- </div> -->
                                @else
                                <!-- <div role="menu" id="user-menu-unauth" class="text-gray-700"> -->
                                <section class="">
                                    <button class="rounded-t-md hover:bg-neutral-100 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" onclick="showLogin();" role="menuitem">Log in</button>
                                    <button class="rounded-b-md hover:bg-neutral-100 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" onclick="showSignup();" role="menuitem">Sign up</button>
                                </section>
                                <!-- </div> -->
                                @endauth
                            </div>
                            
                        </section>


                        <section id="navbar-video" class="flex items-center space-x-2">
                            <button id="btn-nav-folders" class="flex justify-center items-center shrink-0 h-8 w-8 rounded-lg shadow-lg bg-red-300 hover:bg-red-200" aria-label="folders">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" height="24" width="24" class="stroke-slate-900">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                </svg>
                            </button>
                            @auth
                            <button id="btn-nav-history" class="flex justify-center items-center shrink-0 h-8 w-8 rounded-lg shadow-lg bg-purple-300 hover:bg-purple-200" aria-label="watch history">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24" width="24" class="fill-slate-900">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <path fill-rule="evenodd" d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z" />
                                </svg>
                            </button>
                            <button id="btn-nav-settings" class=" hidden flex justify-center items-center shrink-0 h-8 w-8 rounded-lg shadow-lg bg-red-300 hover:bg-red-200" aria-label="settings">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24" width="24" class="fill-slate-900">
                                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            @endauth
                        </section>

                        <div class="toggle-switch shrink-0">
                            <label class="switch-label">
                                <input type="checkbox" class="checkbox invisible" id="dark-mode-toggle">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </span>
                </div>
                <hr class="mt-2 mb-3">
            </nav>
            <section id="content-history" class=" space-y-2 cursor-pointer min-h-[80vh] pt-8">

            </section>
        </section>
        <section id="left-card" class="w-full lg:w-72 shrink-0 hidden lg:block"></section>
    </main>
</x-app-layout>