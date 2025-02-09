<x-guest-layout>
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

    <div class="flex justify-center my-8">
        <form method="GET" action="{{ route('verification.result') }}"
            class="flex items-center space-x-2 p-4 bg-gray-100 rounded-lg shadow-md">
            <input type="text" name="cardNumber" placeholder="Search Members"
                value="{{ request()->query('cardNumber') }}"
                class="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500">
            <button type="submit"
                class="px-4 py-2 bg-sky-700 text-white rounded-lg hover:bg-sky-800 transition">Search</button>
        </form>
    </div>

    <div class="flex justify-center">
        <div class="p-4 text-white max-w-[600px] rounded-r-md">
            @if (!empty($cards) && count($cards) > 0)
            @foreach ($cards as $card)
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
                    <thead class="text-xs text-white uppercase bg-blue-600 border-b border-blue-400 dark:text-white">
                        <tr>
                            <th colspan="2" class="px-6 py-3 text-center bg-blue-500">
                                <img class="max-w-[300px] max-h-[300px]"
                                    src="{{ asset('storage/' . $card->member->member_photo) }}" alt="Member Image">
                            </th>
                        </tr>
                        <tr>
                            <th class="px-6 py-3 bg-blue-500">Card Number</th>
                            <th class="px-6 py-3">{{ $card->number }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['type' => 'Card Type', 'status' => 'Card Status', 'updated_at' => 'Updated At',
                        'member.name' => "Member's Name", 'member.fatherName' => "Father's Name", 'member.motherName' =>
                        "Mother's Name", 'member.nid' => "NID Number", 'member.dob' => "Date of Birth", 'member.gender'
                        => "Gender", 'member.religion' => "Religion", 'member.mobile' => "Mobile", 'member.address' =>
                        "Address", 'member.age' => "Age", 'member.district.name' => "District",
                        'member.sub_district.name' => "Sub District"] as $field => $label)
                        <tr class="bg-blue-600 border-b border-blue-400">
                            <th class="px-6 py-4 bg-blue-500 text-blue-50">{{ $label }}</th>
                            <td class="px-6 py-4">{{ data_get($card, $field) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @php
                    $familyMembers = $card->member->family_members ?? [];
                @endphp

                <h2 class="text-black pt-2">Family Members</h2>

                @if (!empty($familyMembers))
                <table class="w-full mt-4 border-collapse text-black border border-gray-400">
                    <thead>
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">Name</th>
                            <th class="border border-gray-400 px-4 py-2">Gender</th>
                            <th class="border border-gray-400 px-4 py-2">Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($familyMembers as $member)
                        <tr>
                            <td class="border border-gray-400 px-4 py-2">{{ $member['name'] }}</td>
                            <td class="border border-gray-400 px-4 py-2">{{ $member['gender'] }}</td>
                            <td class="border border-gray-400 px-4 py-2">{{ $member['age'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-white">No family members found.</p>
                @endif
            </div>
            @endforeach
            @else
            <p class="text-center text-white">{{ $message ?? 'No results found.' }}</p>
            @endif
        </div>
    </div>
</x-guest-layout>
