

    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Hacer una Reserva</h1>

        <form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="name">Nombre Completo</label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" id="name" placeholder="Tu nombre completo">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="email">Correo Electrónico</label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="email" id="email" placeholder="Tu correo electrónico">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="date">Fecha de la Reserva</label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="date" id="date">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="message">Mensaje (Opcional)</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" id="message" rows="4" placeholder="Mensaje o solicitud especial"></textarea>
            </div>

            <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-500">Enviar Reserva</button>
        </form>
    </div>

