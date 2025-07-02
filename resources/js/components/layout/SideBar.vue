<template>
   <nav id="sidebar" class="">

		<div class="custom-menu">
			<button type="button" id="sidebarCollapse" class="btn btn-primary d-none">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>

		<div class="p-4">

	        <ul class="list-unstyled components mb-5">
              <li><router-link to="/expenses"><span class="fa fa-briefcase mr-3"></span> Settings</router-link></li>
              <li><router-link to="/accounting/expenses"><span class="fa fa-briefcase mr-3"></span> Settings</router-link></li>
	        </ul>

	        <div class="mb-5">
						<h3 class="h6 mb-3">Subscribe for newsletter</h3>
						<form action="#" class="subscribe-form">
	            <div class="form-group d-flex">
	            	<div class="icon"><span class="icon-paper-plane"></span></div>
	              <input type="text" class="form-control" placeholder="Enter Email Address">
	            </div>
	          </form>
					</div>

	        <div class="footer">
	        </div>

	      </div>
    </nav>
</template>

<script>
export default {};
</script>
