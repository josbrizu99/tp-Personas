<template>
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Nacionalidades</h1>
                <p class="mt-2 text-sm text-gray-700">Lista de todas las nacionalidades registradas en el sistema.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button
                    @click="mostrarFormulario = true"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                >
                    Agregar Nacionalidad
                </button>
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
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="nacionalidad in nacionalidades" :key="nacionalidad.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ nacionalidad.nombre }}
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <button
                                            @click="editarNacionalidad(nacionalidad)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            @click="eliminarNacionalidad(nacionalidad.id)"
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

        <!-- Modal para agregar/editar nacionalidad -->
        <div v-if="mostrarFormulario" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="guardarNacionalidad">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    v-model="form.nombre"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    required
                                >
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                {{ form.id ? 'Actualizar' : 'Guardar' }}
                            </button>
                            <button
                                type="button"
                                @click="cerrarFormulario"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'NacionalidadesList',
    data() {
        return {
            nacionalidades: [],
            mostrarFormulario: false,
            form: {
                id: null,
                nombre: ''
            }
        }
    },
    methods: {
        async cargarNacionalidades() {
            try {
                const response = await axios.get('/api/nacionalidades');
                this.nacionalidades = response.data;
            } catch (error) {
                console.error('Error al cargar nacionalidades:', error);
            }
        },
        editarNacionalidad(nacionalidad) {
            this.form = { ...nacionalidad };
            this.mostrarFormulario = true;
        },
        async eliminarNacionalidad(id) {
            if (confirm('¿Está seguro de eliminar esta nacionalidad?')) {
                try {
                    await axios.delete(`/api/nacionalidades/${id}`);
                    this.nacionalidades = this.nacionalidades.filter(n => n.id !== id);
                } catch (error) {
                    console.error('Error al eliminar nacionalidad:', error);
                }
            }
        },
        async guardarNacionalidad() {
            try {
                if (this.form.id) {
                    await axios.put(`/api/nacionalidades/${this.form.id}`, this.form);
                } else {
                    await axios.post('/api/nacionalidades', this.form);
                }
                await this.cargarNacionalidades();
                this.cerrarFormulario();
            } catch (error) {
                console.error('Error al guardar nacionalidad:', error);
            }
        },
        cerrarFormulario() {
            this.mostrarFormulario = false;
            this.form = {
                id: null,
                nombre: ''
            };
        }
    },
    mounted() {
        this.cargarNacionalidades();
    }
}
</script> 