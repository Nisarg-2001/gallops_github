var url = window.location

$("ul.nav-sidebar a").filter(toggleNavSidebar);

function toggleNavSidebar() {
  if (this.href != url) return

  $(this).addClass("active")
}


    