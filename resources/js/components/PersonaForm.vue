<template>
    <div>
      <h2 class="text-2xl font-bold mb-4">Registro de Personas</h2>

      <!-- Navegación por pestañas -->
      <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
          <button v-for="(tab, index) in tabs" :key="tab"
            @click="activeTab = index"
            :class="[activeTab === index ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
              'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']"
            :aria-current="activeTab === index ? 'page' : undefined">
            {{ tab }}
          </button>
        </nav>
      </div>

      <!-- Contenido de las pestañas -->
      <div v-show="activeTab === 0" class="mb-6 p-4 border border-gray-200 rounded-md">
        <h3 class="text-lg font-bold mb-4">Datos Personales</h3>
        <form @submit.prevent="guardarPersona">
          <div class="flex flex-col space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Tipo de Persona</label>
              <select v-model="form.tipo_persona" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option value="física">Física</option>
                <option value="jurídica">Jurídica</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Tipo Identif.</label>
              <select v-model="form.tipo_identificacion" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option value="CI">CI</option>
                <option value="Pasaporte">Pasaporte</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Nro. Doc. (sin DV)</label>
              <input v-model="form.nro_documento" type="text" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
              <input v-model="form.nombre_completo" type="text" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">RUC</label>
              <input v-model="form.ruc" type="text" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Estado Civil</label>
              <select v-model="form.estado_civil" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option value="soltero">Soltero/a</option>
                <option value="casado">Casado/a</option>
                <option value="divorciado">Divorciado/a</option>
                <option value="viudo">Viudo/a</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Sexo</label>
              <select v-model="form.sexo" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">(=)</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Fecha de Nac.</label>
              <input v-model="form.fecha_nacimiento" type="date" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Lugar Nacimiento</label>
              <select v-model="form.lugar_nacimiento" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option v-for="ciudad in ciudades" :key="ciudad.id" :value="ciudad.nombre">{{ ciudad.nombre }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Nacionalidad</label>
              <select v-model="form.nacionalidad" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option v-for="nacionalidad in nacionalidades" :key="nacionalidad.id" :value="nacionalidad.nombre">{{ nacionalidad.nombre }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Profesión</label>
              <input v-model="form.profesion" type="text" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Ocupación</label>
              <input v-model="form.ocupacion" type="text" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input v-model="form.email" type="email" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
          </div>
          <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Guardar</button>
          </div>
        </form>
      </div>

      <!-- Direcciones -->
      <div v-show="activeTab === 1" class="mb-6 p-4 border border-gray-200 rounded-md">
        <h3 class="text-lg font-bold mb-4">Direcciones</h3>
        <div class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Fecha</label>
              <input type="date" v-model="currentAddress.fecha" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Dirección</label>
              <div class="flex">
                <input type="text" v-model="currentAddress.direccion" class="mt-1 block w-full border-gray-300 rounded-md" />
                <button @click="addAddress" class="ml-2 bg-green-500 text-white p-2 rounded-md hover:bg-green-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg>
  </button>
                <button @click="clearAddress" class="ml-2 bg-red-500 text-white p-2 rounded-md hover:bg-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M16.5 4.478a.75.75 0 0 0-1.06-.943L12 7.022 8.56 3.535a.75.75 0 0 0-1.06.943L10.94 8l-3.44 3.465a.75.75 0 0 0 1.06.943L12 8.978l3.44 3.465a.75.75 0 0 0 1.06-.943L13.06 8l3.44-3.465Z" clip-rule="evenodd" /></svg>
  </button>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Tipo Dirección</label>
              <select v-model="currentAddress.tipo_direccion" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option value="Domiciliario">Domiciliario</option>
                <option value="Laboral">Laboral</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Barrio</label>
              <select v-model="currentAddress.barrio" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option v-for="barrio in barrios" :key="barrio.id" :value="barrio.nombre">{{ barrio.nombre }}</option>
              </select>
            </div>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Geolocalización</h3>
            <div class="relative h-64 w-full bg-gray-100 rounded-md overflow-hidden">
              <l-map :zoom="13" :center="[currentAddress.latitud || -25.7949, currentAddress.longitud || -56.4429]" @contextmenu="handleMapClick" style="height: 100%; width: 100%;">
                <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"></l-tile-layer>
                <l-marker v-if="currentAddress.latitud && currentAddress.longitud" :lat-lng="[currentAddress.latitud, currentAddress.longitud]"></l-marker>
              </l-map>
              <button @click="openExternalMap" class="absolute top-2 right-2 bg-white px-3 py-1 rounded-md text-sm shadow">Open Street</button>
            </div>
            <p class="mt-2 text-sm text-gray-600">Click derecho del mouse para indicar latitud y longitud de la ubicación.</p>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Direcciones Registradas</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Dirección</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barrio</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FechaBaja</th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Acciones</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="addresses.length === 0">
                    <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay direcciones registradas.</td>
                  </tr>
                  <tr v-for="(address, index) in addresses" :key="index">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ address.id || 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.fecha }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.tipo_direccion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.direccion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.ciudad }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.barrio }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.estado || 'Activo' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ address.fechabaja || '' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <button @click="editAddress(index)" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                      <button @click="removeAddress(index)" class="ml-4 text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Teléfonos -->
      <div v-show="activeTab === 2" class="mb-6 p-4 border border-gray-200 rounded-md">
        <h3 class="text-lg font-bold mb-4">Teléfonos</h3>
        <div class="text-gray-500">Aquí irá el formulario de teléfonos.</div>
      </div>

      <!-- Trabajos -->
      <div v-show="activeTab === 3" class="mb-6 p-4 border border-gray-200 rounded-md">
        <h3 class="text-lg font-bold mb-4">Trabajos</h3>
        <div class="text-gray-500">Aquí irá el formulario de trabajos.</div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet';
  import 'leaflet/dist/leaflet.css';

  export default {
    name: 'PersonaForm',
    components: {
      LMap,
      LTileLayer,
      LMarker
    },
    data() {
      return {
        tabs: ['Datos Personales', 'Direcciones', 'Teléfonos', 'Trabajos'],
        activeTab: 0,
        form: {
          tipo_persona: '',
          tipo_identificacion: '',
          nro_documento: '',
          nombre_completo: '',
          ruc: '',
          estado_civil: '',
          sexo: '',
          fecha_nacimiento: '',
          lugar_nacimiento: '',
          nacionalidad: '',
          profesion: '',
          ocupacion: '',
          email: ''
        },
        currentAddress: {
          fecha: new Date().toISOString().slice(0, 10),
          direccion: '',
          tipo_direccion: '',
          barrio: '',
          latitud: null,
          longitud: null,
          id: null,
          ciudad: 'Villarrica',
          estado: 'Activo',
          fechabaja: ''
        },
        addresses: [],
        nacionalidades: [],
        ciudades: [],
        barrios: [
          { id: 1, nombre: 'San Blas' },
          { id: 2, nombre: 'Centro' },
          { id: 3, nombre: 'Ybaroty' }
        ]
      }
    },
    mounted() {
      this.cargarNacionalidades();
      this.cargarCiudades();
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
      async cargarCiudades() {
        try {
          const response = await axios.get('/api/ciudades');
          this.ciudades = response.data;
        } catch (error) {
          console.error('Error al cargar ciudades:', error);
        }
      },
      guardarPersona() {
        alert('Persona guardada (demo)');
      },
      handleMapClick(event) {
        this.currentAddress.latitud = event.latlng.lat;
        this.currentAddress.longitud = event.latlng.lng;
      },
      openExternalMap() {
        if (this.currentAddress.latitud && this.currentAddress.longitud) {
          window.open(`https://www.openstreetmap.org/?mlat=${this.currentAddress.latitud}&mlon=${this.currentAddress.longitud}#map=15/${this.currentAddress.latitud}/${this.currentAddress.longitud}`, '_blank');
        } else {
          window.open('https://www.openstreetmap.org/', '_blank');
        }
      },
      addAddress() {
        if (this.currentAddress.direccion && this.currentAddress.tipo_direccion && this.currentAddress.barrio) {
          const newAddress = { ...this.currentAddress };
          if (!newAddress.id) {
            newAddress.id = this.addresses.length > 0 ? Math.max(...this.addresses.map(a => a.id || 0)) + 1 : 1;
          }
          const existingIndex = this.addresses.findIndex(addr => addr.id === newAddress.id);
          if (existingIndex !== -1) {
            this.addresses.splice(existingIndex, 1, newAddress);
          } else {
            this.addresses.push(newAddress);
          }
          this.clearAddress();
        } else {
          alert('Por favor, complete todos los campos de dirección antes de agregar.');
        }
      },
      clearAddress() {
        this.currentAddress = {
          fecha: new Date().toISOString().slice(0, 10),
          direccion: '',
          tipo_direccion: '',
          barrio: '',
          latitud: null,
          longitud: null,
          id: null,
          ciudad: 'Villarrica',
          estado: 'Activo',
          fechabaja: ''
        };
      },
      editAddress(index) {
        this.currentAddress = { ...this.addresses[index] };
      },
      removeAddress(index) {
        if (confirm('¿Está seguro de que desea eliminar esta dirección?')) {
          this.addresses.splice(index, 1);
        }
      }
    }
  }
  </script>

  <style>
  @import 'leaflet/dist/leaflet.css';
  </style>