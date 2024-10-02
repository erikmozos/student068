<main>
        <!-- Sección hero con imagen de fondo y gradiente -->
        <section class="hero bg-cover bg-center h-96 flex items-center justify-center text-white" style="background-image: url('../img/hotel_background.jpg');">
            <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-transparent p-8 rounded-lg shadow-lg text-center">
                <h1 class="text-5xl font-playfair font-extrabold">Bienvenidos a Mozos Hotels</h1>
                <p class="text-2xl mt-4 font-open-sans">Disfruta de una estancia inolvidable en Puertollano</p>
            </div>
        </section>

        <!-- Sección de reservas -->
        <section class="reserva my-16 px-6">
            <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Haz tu reserva ahora</h2>
            <form action="#" method="POST" class="max-w-lg mx-auto p-8 bg-white shadow-lg rounded-lg space-y-6">
                <div>
                    <label for="check-in" class="block text-lg text-blue-800">Fecha de Entrada</label>
                    <input type="date" id="check-in" name="check-in" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                </div>
                <div>
                    <label for="check-out" class="block text-lg text-blue-800">Fecha de Salida</label>
                    <input type="date" id="check-out" name="check-out" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                </div>
                <div>
                    <label for="guests" class="block text-lg text-blue-800">Número de huéspedes</label>
                    <input type="number" id="guests" name="guests" min="1" max="10" required class="w-full p-3 border border-blue-400 rounded-lg focus:outline-none focus:border-yellow-500">
                </div>
                <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600 transition-colors">Reservar ahora</button>
            </form>
        </section>

        <!-- Sección de servicios del hotel -->
        <section class="servicios bg-gradient-to-b from-gray-200 to-gray-100 py-16">
            <h2 class="text-4xl font-playfair font-semibold text-center mb-10 text-blue-900">Nuestros Servicios</h2>
            <div class="flex justify-center space-x-12">
                <div class="servicio-item text-center">
                    <i class="fas fa-swimming-pool text-6xl text-yellow-500"></i>
                    <p class="mt-4 text-xl text-blue-800">Piscina</p>
                </div>
                <div class="servicio-item text-center">
                    <i class="fas fa-concierge-bell text-6xl text-yellow-500"></i>
                    <p class="mt-4 text-xl text-blue-800">Servicio al cuarto</p>
                </div>
                <div class="servicio-item text-center">
                    <i class="fas fa-utensils text-6xl text-yellow-500"></i>
                    <p class="mt-4 text-xl text-blue-800">Restaurante</p>
                </div>
                <div class="servicio-item text-center">
                    <i class="fas fa-spa text-6xl text-yellow-500"></i>
                    <p class="mt-4 text-xl text-blue-800">Spa y Wellness</p>
                </div>
            </div>
        </section>
    </main>