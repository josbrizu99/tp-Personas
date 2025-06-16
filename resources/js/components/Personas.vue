<template>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Lista de Personas</h2>
        
        <!-- Formulario para agregar/editar persona -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h5 class="text-xl font-semibold mb-4">{{ isEditing ? 'Editar Persona' : 'Agregar Nueva Persona' }}</h5>
            <form @submit.prevent="savePersona" class="space-y-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="nombre" v-model="form.nombre" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" id="apellido" v-model="form.apellido" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                    <input type="text" id="dni" v-model="form.dni" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex space-x-4">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ isEditing ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button" @click="resetForm"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de personas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="persona in personas" :key="persona.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ persona.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ persona.nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ persona.apellido }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ persona.dni }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button @click="editPersona(persona)"
                                class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</button>
                            <button @click="deletePersona(persona.id)"
                                class="text-red-600 hover:text-red-900">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            personas: [],
            form: {
                id: null,
                nombre: '',
                apellido: '',
                dni: ''
            },
            isEditing: false
        }
    },
    mounted() {
        this.loadPersonas()
    },
    methods: {
        async loadPersonas() {
            try {
                const response = await fetch('/api/personas')
                this.personas = await response.json()
            } catch (error) {
                console.error('Error al cargar personas:', error)
            }
        },
        async savePersona() {
            try {
                const url = this.isEditing 
                    ? `/api/personas/${this.form.id}`
                    : '/api/personas'
                
                const method = this.isEditing ? 'PUT' : 'POST'
                
                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.form)
                })

                if (response.ok) {
                    await this.loadPersonas()
                    this.resetForm()
                }
            } catch (error) {
                console.error('Error al guardar persona:', error)
            }
        },
        editPersona(persona) {
            this.form = { ...persona }
            this.isEditing = true
        },
        async deletePersona(id) {
            if (confirm('¿Está seguro de eliminar esta persona?')) {
                try {
                    const response = await fetch(`/api/personas/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })

                    if (response.ok) {
                        await this.loadPersonas()
                    }
                } catch (error) {
                    console.error('Error al eliminar persona:', error)
                }
            }
        },
        resetForm() {
            this.form = {
                id: null,
                nombre: '',
                apellido: '',
                dni: ''
            }
            this.isEditing = false
        }
    }
}
</script> 