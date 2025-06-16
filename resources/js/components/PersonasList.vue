<template>
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Personas</h1>
                <p class="mt-2 text-sm text-gray-700">Lista de todas las personas registradas en el sistema.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <router-link
                    to="/personas/create"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                >
                    Agregar Persona
                </router-link>
            </div>
        </div>

        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nombre</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Apellido</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">DNI</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nacionalidad</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="persona in personas" :key="persona.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ persona.nombre }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ persona.apellido }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ persona.dni }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ persona.nacionalidad?.nombre }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <router-link
                                            :to="'/personas/' + persona.id + '/edit'"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4"
                                        >
                                            Editar
                                        </router-link>
                                        <button
                                            @click="eliminarPersona(persona.id)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PersonasList',
    data() {
        return {
            personas: []
        }
    },
    methods: {
        async cargarPersonas() {
            try {
                const response = await axios.get('/api/personas');
                this.personas = response.data;
            } catch (error) {
                console.error('Error al cargar personas:', error);
            }
        },
        async eliminarPersona(id) {
            if (confirm('¿Está seguro de eliminar esta persona?')) {
                try {
                    await axios.delete(`/api/personas/${id}`);
                    this.personas = this.personas.filter(p => p.id !== id);
                } catch (error) {
                    console.error('Error al eliminar persona:', error);
                }
            }
        }
    },
    mounted() {
        this.cargarPersonas();
    }
}
</script> 