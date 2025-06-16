<template>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Lista de Personas</h2>
        
        <!-- Aquí se mostrará el formulario completo de PersonaForm -->
        <PersonaForm />

        <!-- Tabla de personas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
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
import PersonaForm from './PersonaForm.vue' // Importar PersonaForm

export default {
    components: {
        PersonaForm // Registrar PersonaForm como un componente
    },
    data() {
        return {
            personas: [],
            // Ya no necesitamos el formulario aquí, PersonaForm lo manejará
            // form: {
            //     id: null,
            //     nombre: '',
            //     apellido: '',
            //     dni: ''
            // },
            // isEditing: false
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
        // Los métodos de guardar, editar y resetear formulario serán manejados por PersonaForm
        // async savePersona() {
        //     // ... (lógica movida a PersonaForm)
        // },
        // editPersona(persona) {
        //     // ... (lógica movida a PersonaForm)
        // },
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
        }
    }
}
</script> 