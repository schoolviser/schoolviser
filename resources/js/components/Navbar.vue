<!--Website Navbar Component-->
<template>
 <div class="horizontal-menu">

  <nav class="navbar navbar-expand-lg navbar-light top-navbar">
    <div class="container">
      <div>
        <a class="navbar-brand brand-logo" href="">
          <img :src="logo" />
        </a>
      </div>

      <ul class="navbar-nav navbar-nav-right">

        <!-- User Messages -->
        <li class="nav-item dropdown ml-5" style="margin-left: 20px;">
          <a class="nav-link" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-email-outline"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
            <h6 class="p-3 mb-0 font-weight-semibold">Messages</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <img src="" alt="image" class="profile-pic">
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                <p class="text-gray mb-0"> 1 Minutes ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <img src="" alt="image" class="profile-pic">
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                <p class="text-gray mb-0"> 15 Minutes ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <img src="" alt="image" class="profile-pic">
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                <p class="text-gray mb-0"> 18 Minutes ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <h6 class="p-3 mb-0 text-center text-primary font-13">4 new messages</h6>
          </div>
        </li>
        <!-- User notifications-->
        <li class="nav-item dropdown">
          <a class="nav-link" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
            <i class="mdi mdi-bell-outline"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list border border-primary" aria-labelledby="notificationDropdown">
            <h6 class="px-3 py-3 font-weight-semibold mb-0">Notifications</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-success">
                  <i class="mdi mdi-calendar"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject font-weight-normal mb-0">New order recieved</h6>
                <p class="text-gray ellipsis mb-0"> 45 sec ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-warning">
                  <i class="mdi mdi-settings"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject font-weight-normal mb-0">Server limit reached</h6>
                <p class="text-gray ellipsis mb-0"> 55 sec ago </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-info">
                  <i class="mdi mdi-link-variant"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                <h6 class="preview-subject font-weight-normal mb-0">Kevin karvelle</h6>
                <p class="text-gray ellipsis mb-0"> 11:09 PM </p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <h6 class="p-3 font-13 mb-0 text-primary text-center">View all notifications</h6>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#accountQuickLinksOffCanvas" aria-controls="accountQuickLinksOffCanvas">
            <img :src="photo" alt="" class="rounded-circle" style="width: 35px;">
            <div class="nav-profile-text text-capitalize fw-bold px-3">{{ username  }} </div>
          </a>
        </li>
      </ul>

      
      <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

</div>
</template>

<script>

export default {
   name: 'Navbar',
   data(){
    return {
      username : document.querySelector("meta[name='username']").getAttribute('content'),
      photo : document.querySelector("meta[name='user-photo']").getAttribute('content'),
      logo : document.querySelector("meta[name='logo']").getAttribute('content'),
    }
   }
}
</script>