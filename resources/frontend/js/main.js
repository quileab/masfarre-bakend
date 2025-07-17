// Animaciones con Intersection Observer
const animate = document.querySelectorAll(".animate__animated");

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      const element = entry.target;
      const animation = element.getAttribute("data-animate");
      element.classList.add("animate__animated", animation);

      // Remover las clases de animación al finalizar la animación
      element.addEventListener(
        "animationend",
        () => {
          element.classList.remove("animate__animated", animation);
        },
        { once: true }
      ); // Asegura que el evento solo se ejecute una vez
    }
  });
});

animate.forEach((element) => {
  observer.observe(element);
});

// Navbar
const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");
const menuIcon = document.getElementById("menu-icon");
const closeIcon = document.getElementById("close-icon");

menuToggle.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");
  menuIcon.classList.toggle("hidden");
  closeIcon.classList.toggle("hidden");
});

new VenoBox({
  selector: ".events-gallery",
});

document.addEventListener("DOMContentLoaded", () => {
  fetch('./gmComments.php')
    .then(response => response.json())
    .then(data => {
      const contenedor = document.getElementById('comentarios');

      if (Array.isArray(data)) {
        data.forEach(comentario => {
          const div = document.createElement('div');
          div.innerHTML = `
            <div class="flex flex-col rounded-lg bg-gray-100 dark:bg-gray-800 border border-purple-500 p-4">
              <p class="text-gray-500 dark:text-gray-400 mb-4"> 
                ⭐${comentario.rating}/5
              </p>
              <p class="text-gray-500 dark:text-gray-400 line-clamp-3 overflow-clip text-ellipsis">
                <a href="${comentario.author_url}" target="_blank">
                ${comentario.text} <br><br><br>
                </a>
              </p>
              <hr class="my-4 border-purple-500/50">
              <div class="flex items-center gap-x-2 text-gray-500 dark:text-gray-400">
                <img src="${comentario.profile_photo_url}" alt="Foto de perfil" class="w-12 h-12 rounded-full"> 
                <span class="text-sm">
                  <b>${comentario.author_name}</b>
                  <br>
                    ${new Date(comentario.time*1000).toLocaleDateString('es-ES', {
                      year: 'numeric',
                      month: 'numeric',
                      day: 'numeric',
                    })}
                </span>
              </div>
            </div>
          `;
          contenedor.appendChild(div);
        });
      } else if (data.error) {
        contenedor.innerHTML = `<p>${data.error}</p>`;
      }
    })
    .catch(error => {
      console.error('Error al obtener reseñas:', error);
      document.getElementById('comentarios').innerHTML = '<p>Error al cargar los comentarios.</p>';
    });
});
