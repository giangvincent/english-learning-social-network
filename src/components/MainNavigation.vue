<template>
  <nav id="header" class="bg-white w-full z-20 top-0 fixed shadow">
    <div
      class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-4 py-2"
    >
      <label for="menu-toggle" class="cursor-pointer md:hidden block">
        <svg
          class="fill-current text-gray-900"
          xmlns="http://www.w3.org/2000/svg"
          width="20"
          height="20"
          viewBox="0 0 20 20"
        >
          <title>menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </label>
      <input class="hidden" type="checkbox" id="menu-toggle" />

      <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
        <nav>
          <ul class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0">
            <li>
              <a
                class="inline-block no-underline hover:text-black hover:underline py-2 px-4"
                href="#"
              >Shop</a>
            </li>
            <li>
              <a
                class="inline-block no-underline hover:text-black hover:underline py-2 px-4"
                href="#"
              >About</a>
            </li>
          </ul>
        </nav>
      </div>

      <div class="order-1 md:order-2">
        <a
          class="items-center hover:no-underline font-bold text-gray-800 text-xl uppercase"
          href="index.html"
        >ohitsgood</a>
      </div>

      <div class="order-2 md:order-3 flex items-center" id="nav-content">
        <a class="inline-block no-underline hover:text-black" href="auth.html">
          <svg
            class="fill-current hover:text-black"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
          >
            <circle fill="none" cx="12" cy="7" r="3" />
            <path
              d="M12 2C9.243 2 7 4.243 7 7s2.243 5 5 5 5-2.243 5-5S14.757 2 12 2zM12 10c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3S13.654 10 12 10zM21 21v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h2v-1c0-2.757 2.243-5 5-5h4c2.757 0 5 2.243 5 5v1H21z"
            />
          </svg>
        </a>
      </div>
    </div>
    <!-- End topbar lvl0 -->
    <div class="w-full mx-auto flex text-center font-bold">
      <a href="#" class="w-1/3 py-3 border-b-2 border-gray-900">Từ vựng</a>
      <a href="#" class="w-1/3 py-3">Video</a>
      <a href="#" class="w-1/3 py-3">Bài viết</a>
    </div>
    <!-- END topbar lvl1 -->
  </nav>
</template>