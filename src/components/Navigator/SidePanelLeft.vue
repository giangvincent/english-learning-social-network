<template>
  <div class="hidden">
    <div class="bg-black bg-opacity-50 fixed z-30 top-0 bottom-0 left-0 right-0"></div>
    <!-- shade -->
    <section class="fixed top-0 bottom-0 z-30 w-screen">
      <nav style="width: 264px" class="bg-white min min-h-full shadow-2xl">
        <div>
          <ul class="menu-list">
            <li class="drawer-item drawer-item--customize">
              <a href="/" class="picture">
                <div class="thumbnail round home"></div>Home
              </a>
              <a href="/customize" class="customize-container">
                <i class="icn icn-customize"></i>
              </a>
            </li>
            <li class="drawer-item">
              <a
                href="https://9gag.page.link/?link=https%3A%2F%2F9gag.com%2Fusa%2Ffresh&amp;apn=com.ninegag.android.app&amp;ibi=com.9gag.ios.mobile&amp;isi=545551605&amp;efr=1"
                target="_blank"
                class="picture"
              >
                <i class="thumbnail grey icn phone-000"></i>
                Get 9GAG app
              </a>
            </li>
            <li class="drawer-item">
              <a href="/pro" class="picture">
                <i class="thumbnail pro-icn cup"></i>
                Get 9GAG PRO
              </a>
              <div class="pro-container">
                <span class="pro-badge">PRO</span>
              </div>
            </li>
          </ul>
          <ul class="menu-list">
            <div class="section-header">FAVORITES</div>
            <li class="drawer-item">
              <a href="/funny" class="picture">
                <div class="thumbnail large">
                  <picture>
                    <source
                      srcset="https://miscmedia-9gag-fun.9cache.com/images/thumbnail-facebook/1557376304.186_U5U7u5_100x100wp.webp"
                      type="image/webp"
                    />
                    <img
                      src="https://miscmedia-9gag-fun.9cache.com/images/thumbnail-facebook/1557376304.186_U5U7u5_100x100.jpg"
                      loading="lazy"
                    />
                  </picture>
                </div>Funny🔥
              </a>
            </li>
            <li class="drawer-item">
              <a href="/random" class="picture">
                <div class="thumbnail large">
                  <picture>
                    <source
                      srcset="https://miscmedia-9gag-fun.9cache.com/images/thumbnail-facebook/1481541784.8502_e8ARAR_100x100wp.webp"
                      type="image/webp"
                    />
                    <img
                      src="https://miscmedia-9gag-fun.9cache.com/images/thumbnail-facebook/1481541784.8502_e8ARAR_100x100.jpg"
                      loading="lazy"
                    />
                  </picture>
                </div>Random
              </a>
            </li>
          </ul>
          <!---->
        </div>
      </nav>
    </section>
  </div>
  <!-- Slide panel left -->
</template>