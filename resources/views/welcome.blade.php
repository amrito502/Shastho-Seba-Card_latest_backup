<x-guest-layout>

    {{-- Navigation Guest --}}
    <nav class="bg-white border-b border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Shastho Seba
                    Card</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li><a href="/" class="block py-2 px-3 text-blue-700 dark:text-blue-500">Home</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">About</a>
                    </li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">Services</a>
                    </li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">Pricing</a>
                    </li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">Contact</a>
                    </li>
                    @auth
                    <li><a href="route('filament.admin.pages.dashboard')"
                            class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">Admin Panel</a></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit"
                                class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700 w-full text-left">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </li>

                    @else
                    <li><a href="{{ route('login') }}"
                            class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">Login</a></li>
                    <li><a href="{{ route('register') }}"
                            class="block py-2 px-3 text-gray-900 dark:text-white hover:text-blue-700">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>


    {{-- Carousel Slider --}}
    <div id="default-carousel" class="relative border w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://www.e-healthbd.com/uploads/slider/1659544085.Halim%20PICd.webp"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://www.e-healthbd.com/uploads/slider/1659544119.Halim%20PIC.webp"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>

            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://www.e-healthbd.com/uploads/slider/1665758769.IMG-20221014-WA0001.webp"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>


        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center  justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex bg-black items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex bg-black items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    {{-- Hero Section --}}
    <div class="hero bg-gray-100 m-4 py-8 text-center rounded-lg">
        <div class="text-4xl font-bold">Manage Your Health Card</div>
        <div class="text-xl p-4">Choose an option below to verify or register your health card</div>
        <div class="buttons my-4 flex justify-center flex-col md:flex-row ">
            <a href="{{ route('verification') }}" class="bg-red-900 text-white py-4 mx-2 px-6 mb-2 md:mb-0">Health Card Verification</a>
            <a href="" class="bg-sky-900 text-white py-4 mx-2 px-6 mt-2 md:mt-0">Health Card Registration</a>
        </div>
    </div>

    {{-- Filter --}}

        <div class="flex flex-row">
            <form method="GET" action="{{ route('homes.index') }}" class="flex items-center justify-center w-full max-w-md mx-auto space-x-2 p-4 bg-gray-100 rounded-lg shadow-md">
                <input
                    type="text"
                    name="search"
                    placeholder="Search District, Hospital Name"
                    value="{{ request()->query('search') }}"
                    class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500"
                >
                <button
                    type="submit"
                    class="px-4 py-2 bg-sky-700 text-white rounded-lg hover:bg-sky-800 transition">
                    Search
                </button>
            </form>

        </div>




    {{-- Cards --}}
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-10">

            {{-- Card Item --}}
            @foreach ($organizations as $organization)
                <div class="rounded-lg bg-sky-100 overflow-hidden border p-4 shadow-lg">

                    <div class="topbar flex justify-between pb-2">
                        <div class="tl">
                            <img style="max-width: 100px;" src="{{ asset('storage/' . $organization->logo) }}" alt="icon">
                        </div>
                        <div class="tr text-red-600">(Get {{$organization->minDiscount}} to {{$organization->maxDiscount}}% Discount)</div>
                    </div>

                    <div class="bottombar flex justify-between pt-2">
                        <div class="tr font-bold text-md">{{ $organization->name }}</div>
                        <div class="tl bg-white rounded-full">
                            <a href="#"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z"
                                    clip-rule="evenodd" />
                            </svg></a>
                        </div>
                    </div>
                    <div class="bg-red-800 py-[1px] mt-2"></div>
                    <div class="pt-2 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                          </svg>

                          {{$organization->address}}
                    </div>
                </div>
            @endforeach

        </div>
        {{ $organizations->links() }}

    </div>



</x-guest-layout>
