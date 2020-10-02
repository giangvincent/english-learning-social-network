<template>
  <div class="hidden md:block ">
    <div
      class="bg-black bg-opacity-50 fixed z-30 top-0 bottom-0 left-0 right-0 md:hidden"
    ></div>
    <!-- shade -->
    <section
      class="transform md:transform-none ease-in-out transition-all duration-300 translate-x-0 -translate-x-full fixed top-0 bottom-0 z-30 w-64 md:w-1/5 lg:w-1/6 h-screen md:pt-16"
    >
      <nav class="bg-white md:bg-none min min-h-full shadow-2xl md:shadow-none">
        <div class="px-1 xl:px-4">
          <ul class="flex flex-col w-full">
            <li class="my-px">
              <a
                href="#"
                class="flex flex-row items-center h-12 px-2 xl:px-4 rounded-lg bg-gray-100"
              >
                <span class="flex items-center justify-center">
                  <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    ></path>
                  </svg>
                </span>
                <span class="ml-2">Dashboard</span>
                <span
                  class="flex items-center justify-center text-sm font-semibold bg-gray-200 h-6 px-2 rounded-full ml-auto"
                  >3</span
                >
              </a>
            </li>
            <li class="my-px">
              <span class="flex font-bold px-4 my-4 uppercase">Projects</span>
            </li>
            <li class="my-px">
              <a
                href="#"
                class="flex flex-row items-center h-12 px-2 xl:px-4 rounded-lg hover:bg-gray-100"
              >
                <span class="flex items-center justify-center">
                  <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                    ></path>
                  </svg>
                </span>
                <span class="ml-2">Manager</span>
              </a>
            </li>
            <li class="my-px">
              <a
                href="#"
                class="flex flex-row items-center h-12 px-2 xl:px-4 rounded-l hover:bg-gray-100"
              >
                <span class="flex items-center justify-center">
                  <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                    ></path>
                  </svg>
                </span>
                <span class="ml-2">Tasks</span>
              </a>
            </li>
            <li class="my-px">
              <a
                href="#"
                class="flex flex-row items-center h-12 px-2 xl:px-4 rounded-lg hover:bg-gray-100"
              >
                <span class="flex items-center justify-center">
                  <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                  </svg>
                </span>
                <span class="ml-2">Clients</span>
                <span
                  class="flex items-center justify-center text-sm font-semibold bg-gray-200 h-6 px-2 rounded-full ml-auto"
                  >1k</span
                >
              </a>
            </li>

            <li class="my-px">
              <span class="flex font-bold px-4 my-4 uppercase">Account</span>
            </li>
            <li class="my-px">
              <a
                href="#"
                class="flex flex-row items-center h-12 px-2 xl:px-4 rounded-lg hover:bg-gray-100"
              >
                <span class="flex items-center justify-center">
                  <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    ></path>
                  </svg>
                </span>
                <span class="ml-2">Profile</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </section>
  </div>
  <!-- Slide panel left -->
</template>
