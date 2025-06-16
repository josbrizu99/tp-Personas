<template>
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Gestión de Personas</h1>
            <Personas />
        </div>
    </div>
</template>

<script>
import Personas from './components/Personas.vue'

export default {
    name: 'App',
    components: {
        Personas
    }
}
</script> 