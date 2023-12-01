$(document).ready(function () {
  $("#loader").hide();
});

const body = document.querySelector("body");
const darkLight = document.querySelector("#darkLight");
const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");
const sidebarOpen = document.querySelector("#sidebarOpen");
const sidebarClose = document.querySelector(".collapse_sidebar");
const sidebarExpand = document.querySelector(".expand_sidebar");
// Recuperar el tema del almacenamiento en caché
var temaGuardado = localStorage.getItem("tema");

// Si no hay tema guardado en caché, usa el tema del sistema
if (temaGuardado === null) {
  if (
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    body.classList.add("dark");
    darkLight.classList.replace("fa-sun", "fa-moon");
  }
} else {
  // Si hay un tema guardado en caché, úsalo
  if (temaGuardado === "dark") {
    body.classList.add("dark");
    darkLight.classList.replace("fa-sun", "fa-moon");
  } else {
    body.classList.remove("dark");
    darkLight.classList.replace("fa-moon", "fa-sun");
  }
}

sidebarOpen.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

sidebarClose.addEventListener("click", () => {
  const content = document.querySelector(".content");
  if (window.innerWidth > 768) {
    content.style.marginLeft = "100px";
  }

  sidebar.classList.add("close", "hoverable");
});

sidebarExpand.addEventListener("click", () => {
  const content = document.querySelector(".content");
  if (window.innerWidth > 768) {
    content.style.marginLeft = "260px";
  } else {
    content.style.marginLeft = "100px";
  }

  sidebar.classList.remove("close", "hoverable");
});

submenuItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    item.classList.toggle("show_submenu");
    submenuItems.forEach((item2, index2) => {
      if (index !== index2) {
        item2.classList.remove("show_submenu");
      }
    });
  });
});

function ajustarSidebar() {
  var navContentsHide = document.getElementById("hideMobile");
  var bottom_content = document.getElementsByClassName("bottom_content");
  bottom_content = bottom_content[0];

  if (window.innerWidth < 768) {
    sidebar.classList.add("close");

    navContentsHide.style.display = "none";

    if (!document.getElementById("elementoParaEliminar")) {
      const htmlNotifications = document.getElementById("notificationsMenu");
      console.log(htmlNotifications);
      sidebar.insertAdjacentHTML(
        "afterbegin",
        `<div id="elementoParaEliminar">
            <a href='${base_url}/perfil/inicio'>
                <img src="${base_url}/resources/img/profiles/${profile_pic}" alt="" class="profile" / style='width: 50px;border-radius: 50%;'>
            </a>
            <span class="title nombreUser">${nombreUser}</span>
        </div>`
      );

      bottom_content.classList.add("hide");
    }
  } else {
    if (sidebar.classList.contains("close")) {
      sidebar.classList.remove("close");
    }
    navContentsHide.style.display = "flex";
    navContentsHide.style.alignItems = "center";
    navContentsHide.style.gap = "10px";
    bottom_content.classList.remove("hide");

    var elementoParaEliminar = document.getElementById("elementoParaEliminar");
    if (elementoParaEliminar) {
      elementoParaEliminar.remove();
    }
  }
}

// Llama a la función para configurar el estado inicial
ajustarSidebar();

// Agrega un evento 'resize' para ajustar el sidebar cuando cambie el tamaño de la ventana
window.addEventListener("resize", ajustarSidebar);

darkLight.addEventListener("click", () => {
  body.classList.toggle("dark");
  if (body.classList.contains("dark")) {
    document.setI;
    darkLight.classList.replace("fa-sun", "fa-moon");
    localStorage.setItem("tema", "dark");
  } else {
    darkLight.classList.replace("fa-moon", "fa-sun");
    localStorage.setItem("tema", "light");
  }
});

$(".verNoti").on("click", function (e) {
  e.preventDefault();
  let noti = $(this).data("noti");
  let id = $(this).data("id");
  $("#id_mensaje").val(id);
  $("#bodyNoti").html(noti);
  $("#modalNoti").modal("show");
});

$(".leido").on("click", function (e) {
  e.preventDefault();
  let id = $("#id_mensaje").val();
  $.ajax({
    url: base_url + "/inactivoMensajeCa",
    type: "post",
    dataType: "json",
    data: {
      id: id,
    },
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (data) {
      location.reload();
    },
    error: function (jqXHR) {
      Swal.fire({
        icon: "error",
        title: `Error ${jqXHR.status}`,
        text: "Contacte con el equipo Redesla.",
      });
    },
    complete: function () {
      $("#loader").hide();
    },
  });
});

$("#showInactivas").on("click", function (e) {
  e.preventDefault();
  let text = $(this).text();
  if (text == "Ver todas") {
    $(".notification_ul li.hide").removeClass("hide");
    $("#showInactivas").text("Ver solo activas");
  } else {
    $(".notification_ul li[data-activo='0']").addClass("hide");
    $("#showInactivas").text("Ver todas");
  }
});

$(".profile .icon_wrap").click(function () {
  $(this).parent().toggleClass("active");
  $(".notifications").removeClass("active");
});

$(".notifications .icon_wrap").click(function () {
  $(this).parent().toggleClass("active");
  $(".profile").removeClass("active");
});

$(".show_all .link").click(function () {
  $(".notifications").removeClass("active");
  $(".popup").show();
});

$(".close, .shadow").click(function () {
  $(".popup").hide();
});
