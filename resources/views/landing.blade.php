<x-layouts.frontend>
    <!-- Responsive Navbar with vanilla JS -->
    <nav class="bg-white shadow-md dark:bg-gray-800 dark:text-white">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="#" class="flex items-center">
                <img src="{{ asset('frontend/images/logooscuro.png') }}" alt="Logo" class="h-8 mr-2 dark:hidden">
                <img src="{{ asset('frontend/images/logoclaro.png') }}" alt="Logo" class="h-8 mr-2 light:hidden">
            </a>

            <div class="hidden md:flex space-x-4">
                <a href="#about" class="hover:text-red-700 font-bold">Nosotros</a>
                <a href="#servicios" class="hover:text-orange-700 font-bold">Servicios</a>
                <a href="#tendencias" class="hover:text-fuchsia-700 font-bold">Tendencias</a>
            </div>

            <button id="menu-toggle" class="md:hidden text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800
          dark:focus:text-white dark:hover:text-white dark:text-white">
                <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                    <path id="menu-icon" fill-rule="evenodd" clip-rule="evenodd"
                        d="M4 6H20V8H4V6ZM4 11H20V13H4V11ZM4 16H20V18H4V16Z" />
                    <path id="close-icon" class="hidden" fill-rule="evenodd" clip-rule="evenodd"
                        d="M18.707 17.293a1 1 0 0 1-1.414 1.414L12 13.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L10.586 12 5.293 6.707a1 1 0 0 1 1.414-1.414L12 10.586l5.293-5.293a1 1 0 0 1 1.414 1.414L13.414 12l5.293 5.293Z" />
                </svg>
            </button>
        </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden dark:bg-gray-900 dark:text-white bg-gray-100 text-gray-900
      position-relative z-50 top-0 inset-x-0 p-4">
            <div class="px-4 py-2 space-y-1">
                <a href="#" class="block hover:bg-gray-100/20 px-3 py-2 rounded">Nosotros</a>
                <a href="#" class="block hover:bg-gray-100/20 px-3 py-2 rounded">Servicios</a>
                <a href="#" class="block hover:bg-gray-100/20 px-3 py-2 rounded">Tendencias</a>
            </div>
        </div>
    </nav>
    <section id="hero">
        <section id="hero" class="relative w-full">
        <img src="{{ asset('frontend/images/backgroundheader.jpg') }}" alt="Fondo" class="w-full h-auto">
        <div class="spectrum-container">
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
            <div class="spectrum-bar"></div>
        </div>
    </section>
    </section>
    <section id="about" class="m-8">
        <img src="{{ asset('frontend/images/about.jpg') }}" alt="Fondo"
            class="w-full md:h-52 h-full object-cover rounded-2xl">
        <div data-animate="animate__fadeInLeft" class="animate__animated animate__slow">
            <h1 class="text-3xl font-russo tracking-widest my-4">SOBRE <span class="masf-red">NOSOTROS</span></h1>
            <p class="text-justify indent-8 text-slate-500">
                En Masfarre Servicios Audiovisuales nos encanta formar parte de tus momentos más especiales. Nos
                dedicamos a
                llevar la mejor tecnología y creatividad a cada evento, desde pantallas LED y fotografía hasta DJ,
                efectos
                especiales y todo lo que necesites para que tu fiesta sea única. Sabemos que cada celebración tiene su
                propio
                estilo, por eso trabajamos codo a codo con vos para que todo salga tal cual lo soñaste. Desde cumpleaños
                y
                casamientos hasta eventos empresariales, ponemos toda la onda y profesionalismo para que tu evento quede
                en la
                memoria de todos.
            <p class="text-justify indent-8 text-slate-500">
                No solo hacemos eventos, creamos experiencias que se viven y disfrutan a pleno.
            </p>
            <p class="text-justify indent-8 text-slate-500">
                Si buscás algo diferente, <i>¡acá estamos para hacerlo realidad!</i>
            </p>
        </div>
    </section>

    <section id="eventos" class="m-8">
        <img src="{{ asset('frontend/images/ultevent.jpg') }}" alt="Fondo"
            class="w-full md:h-52 h-full object-cover rounded-2xl">
        <div data-animate="animate__fadeInLeft" class="animate__animated animate__slow">
            <h1 class="text-3xl font-russo tracking-widest my-4">ULTIMOS <span class="masf-orange">EVENTOS</span></h1>
            <p class="text-justify indent-8 text-slate-500">
                Conoce lo último en tendencias audiovisuales.
            </p>
        </div>
        <div id="gallery" class="grid md:grid-cols-3 grid-cols-2 gap-4 mt-4">
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/1.jpg') }}">
                <img src="{{ asset('frontend/images/events/1.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/2.jpg') }}">
                <img src="{{ asset('frontend/images/events/2.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/3.jpg') }}">
                <img src="{{ asset('frontend/images/events/3.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/4.jpg') }}">
                <img src="{{ asset('frontend/images/events/4.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/5.jpg') }}">
                <img src="{{ asset('frontend/images/events/5.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/6.jpg') }}">
                <img src="{{ asset('frontend/images/events/6.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/7.jpg') }}">
                <img src="{{ asset('frontend/images/events/7.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/8.jpg') }}">
                <img src="{{ asset('frontend/images/events/8.jpg') }}">
            </a>
            <a class="events-gallery" data-gall="gallery01" href="{{ asset('frontend/images/events/9.jpg') }}">
                <img src="{{ asset('frontend/images/events/9.jpg') }}">
            </a>
        </div>
    </section>

    <section id="contactus" class="flex bg-masfarre-geometry text-white bg-gray-900 p-8 align-middle items-center">
        <h1 class="text-3xl font-russo py-4">Estamos disponibles para programar tu evento <span
                class="animate-ping">_</span></h1>
        <a href="#contact" class="hover:underline text-white/70 hover:text-white text-xl ml-4">
            Contactanos
        </a>
    </section>

    <section id="about" class="m-8">
        <img src="{{ asset('frontend/images/about.jpg') }}" alt="Fondo"
            class="w-full md:h-52 h-full object-cover rounded-2xl">
        <div data-animate="animate__fadeInLeft" class="animate__animated animate__fast">
            <h1 class="text-3xl font-russo tracking-widest mt-4">ULTIMOS <span class="masf-fuchsia">POSTS</span></h1>
            <p class="text-justify indent-8 text-slate-500">
                Lo que dicen los que nos conocen
            </p>
            <!-- respuesta de JSON -->
            <div id="comentarios" class="grid md:grid-cols-5 grid-cols-2 gap-4 mt-4"></div>

        </div>
    </section>


    <section id="contact" class="m-8">
        <div data-animate="animate__fadeInLeft" class="animate__animated animate__slow">
            <h1 class="text-3xl font-russo tracking-widest my-4">CONTACTANOS <span
                    class="masf-violet">¿HABLAMOS?...</span>
            </h1>
            <div class=" grid grid-cols-1 md:grid-cols-2 gap-4">
                <div id="contact-description">
                    <p class="text-justify indent-8 text-slate-500 mb-4">
                        Estamos acá para ayudarte. Podés completar el formulario en esta sección y nos pondremos en
                        contacto con vos
                        lo
                        antes posible. Si preferís, también podés llamarnos de lunes a viernes, entre las 9:00 y las
                        20:00, ¡y
                        charlamos
                        directamente! Estamos para responder tus dudas y hacer realidad tus ideas.
                    </p>
                    <p class="leading-8">
                        <i class="ph-bold ph-map-pin text-xl"></i>
                        <b>Direccion:</b> Olessio 817, Reconquista, Santa Fe 3560
                        <br>
                        <i class="ph-bold ph-envelope text-xl"></i>
                        <b>Email:</b> edy@masfarre.com
                        <br>
                        <i class="ph-bold ph-phone text-xl"></i>
                        <b>Teléfono:</b> +
                        <br>
                        <i class="ph-bold ph-instagram-logo text-xl"></i>
                        <b>Instagram:</b> @masfarre.ok
                        <br>
                    </p>

                </div>
                <div>
                    <form class="p-4 shadow-md rounded-md" action="sendmail.php" method="POST">
                        <input name="fullname" class="w-full p-2 rounded-md border border-gray-300 mb-4" type="text"
                            placeholder="Apellido y Nombre" required>
                        <input name="email" class="w-full p-2 rounded-md border border-gray-300 mb-4" type="email"
                            placeholder="Email" required>
                        <input name="phone" class="w-full p-2 rounded-md border border-gray-300 mb-4" type="tel"
                            placeholder="Teléfono" required>
                        <label class="text-xs"><span class="masf-red">*</span> Fecha del Evento</label>
                        <input name="eventdate" class="w-full p-2 rounded-md border border-gray-300 mb-4" type="date"
                            placeholder="Fecha del evento" required>
                        <input name="eventtype" class="w-full p-2 rounded-md border border-gray-300 mb-4" type="text"
                            placeholder="Tipo de evento" required>
                        <input name="eventplace" class="w-full p-2 rounded-md border border-gray-300 mb-4" type="text"
                            placeholder="Lugar del evento" required>
                        <textarea name="message" class="w-full p-2 rounded-md border border-gray-300 mb-4" rows="4"
                            placeholder="Mensaje" required></textarea>
                        <button type="submit"
                            class="transition duration-300 w-full p-2 rounded-md border-2 bg-red-600 text-white hover:border-red-600 hover:text-black hover:bg-white">
                            Enviar <i class="ph-bold ph-paper-plane-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="footer" class="clip-footer grid grid-cols-2 bg-masfarre-party bg-gray-900 p-8 items-baseline mb-8">
        <img src="{{ asset('frontend/images/logoclaro.png') }}" alt="Masfarre" class="w-2/3 h-auto mx-auto">
        <p class="text-right text-white pr-4">
            <i class="ph-bold ph-copyright"></i>
            <span class="masf-violet">Inno</span><span>Design</span>
        </p>
    </section>

</x-layouts.frontend>