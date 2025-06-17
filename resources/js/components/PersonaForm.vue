<template>
    <div>
      <h2 class="text-2xl font-bold mb-4">Registro de Personas</h2>

      <!-- Navegación por pestañas -->
      <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
          <button v-for="(tab, index) in tabs" :key="tab"
            @click="selectTab(index)"
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
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
            <div class="md:col-span-2">
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
            <div class="col-span-1 md:col-span-3">
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
              <label class="block text-sm font-medium text-gray-700">Ciudad</label>
              <select v-model="currentAddress.ciudad" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option v-for="ciudad in ciudades" :key="ciudad.id" :value="ciudad.nombre">{{ ciudad.nombre }}</option>
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
              <div class="mt-6 flex justify-end">
                <button @click="saveAddresses" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Guardar Direcciones</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Teléfonos -->
      <div v-show="activeTab === 2" class="mb-6 p-4 border border-gray-200 rounded-md">
        <h3 class="text-lg font-bold mb-4">Teléfonos</h3>
        <div class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Tipo de Teléfono:</label>
              <select v-model="currentPhone.tipo_telefono" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option value="Particular">Particular</option>
                <option value="Laboral">Laboral</option>
                <option value="Celular">Celular</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Fecha Alta:</label>
              <input type="date" v-model="currentPhone.fecha_alta" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div></div> <!-- Espacio en blanco para la cuadrícula -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
              <div class="flex">
                <input type="text" v-model="currentPhone.nro_telefono" class="mt-1 block w-full border-gray-300 rounded-md" />
                <button @click="addPhone" class="ml-2 bg-green-500 text-white p-2 rounded-md hover:bg-green-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg></button>
                <button @click="clearPhone" class="ml-2 bg-red-500 text-white p-2 rounded-md hover:bg-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M16.5 4.478a.75.75 0 0 0-1.06-.943L12 7.022 8.56 3.535a.75.75 0 0 0-1.06.943L10.94 8l-3.44 3.465a.75.75 0 0 0 1.06.943L12 8.978l3.44 3.465a.75.75 0 0 0 1.06-.943L13.06 8l3.44-3.465Z" clip-rule="evenodd" /></svg></button>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">A cargo de:</label>
              <input type="text" v-model="currentPhone.a_nombre_de" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Estado:</label>
              <select v-model="currentPhone.estado" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Teléfonos Registrados</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Alta</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Teléfono</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nro. Teléfono</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">A Nombre De</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Acciones</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="phones.length === 0">
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay teléfonos registrados.</td>
                  </tr>
                  <tr v-for="(phone, index) in phones" :key="index">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ phone.id || 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ phone.fecha_alta }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ phone.tipo_telefono }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ phone.nro_telefono }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ phone.a_nombre_de }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ phone.estado }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <button @click="editPhone(index)" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                      <button @click="removePhone(index)" class="ml-4 text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="mt-6 flex justify-end">
          <button @click="savePhones" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Guardar Teléfonos</button>
        </div>
      </div>

      <!-- Trabajos -->
      <div v-show="activeTab === 3" class="mb-6 p-4 border border-gray-200 rounded-md">
        <h3 class="text-lg font-bold mb-4">Trabajos</h3>
        <div class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Condición Laboral:</label>
              <select v-model="currentWork.condicion_laboral" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">Seleccione</option>
                <option value="Activo">Activo</option>
                <option value="Jubilado">Jubilado</option>
                <option value="Desempleado">Desempleado</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Fecha Ingreso:</label>
              <input type="date" v-model="currentWork.fecha_ingreso" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div></div> <!-- Espacio en blanco para la cuadrícula -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Empresa:</label>
              <div class="flex">
                <input type="text" v-model="currentWork.empresa" class="mt-1 block w-full border-gray-300 rounded-md" />
                <button @click="addWork" class="ml-2 bg-green-500 text-white p-2 rounded-md hover:bg-green-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg></button>
                <button @click="clearWork" class="ml-2 bg-red-500 text-white p-2 rounded-md hover:bg-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M16.5 4.478a.75.75 0 0 0-1.06-.943L12 7.022 8.56 3.535a.75.75 0 0 0-1.06.943L10.94 8l-3.44 3.465a.75.75 0 0 0 1.06.943L12 8.978l3.44 3.465a.75.75 0 0 0 1.06-.943L13.06 8l3.44-3.465Z" clip-rule="evenodd" /></svg></button>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Sección:</label>
              <input type="text" v-model="currentWork.seccion" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Sector Económico:</label>
              <input type="text" v-model="currentWork.sector_economico" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Cargo:</label>
              <input type="text" v-model="currentWork.cargo" class="mt-1 block w-full border-gray-300 rounded-md" />
            </div>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-2">Trabajos Registrados</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Alta</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actual</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condicion</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa / I...</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seccion</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FCCADO</th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Acciones</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="works.length === 0">
                    <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay trabajos registrados.</td>
                  </tr>
                  <tr v-for="(work, index) in works" :key="index">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ work.id || 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.fecha_ingreso }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.actual ? 'Sí' : 'No' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.condicion_laboral }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.empresa }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.seccion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.sector_economico }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ work.cargo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <button @click="editWork(index)" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                      <button @click="removeWork(index)" class="ml-4 text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="mt-6 flex justify-end">
          <button @click="saveJobs" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Guardar Trabajos</button>
        </div>
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
        personalDataLoaded: false,
        addressesLoaded: false,
        phonesLoaded: false,
        jobsLoaded: false,
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
        currentPhone: {
          id: null,
          tipo_telefono: '',
          fecha_alta: new Date().toISOString().slice(0, 10),
          nro_telefono: '',
          a_nombre_de: '',
          estado: 'Activo'
        },
        phones: [],
        addresses: [],
        currentWork: {
          id: null,
          condicion_laboral: '',
          fecha_ingreso: new Date().toISOString().slice(0, 10),
          empresa: '',
          seccion: '',
          sector_economico: '',
          cargo: '',
          actual: false
        },
        works: [],
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
        // Aquí iría la lógica real para guardar la persona en la base de datos
        alert('Datos personales guardados (demo)');
        this.personalDataLoaded = true;
        this.activeTab = 1; // Mover a la siguiente pestaña después de guardar
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
      saveAddresses() {
        // Lógica para guardar direcciones (por ejemplo, enviar a la API)
        if (this.addresses.length > 0) {
          alert('Direcciones guardadas (demo)');
          this.addressesLoaded = true;
          this.activeTab = 2; // Mover a la siguiente pestaña
        } else {
          alert('Debe añadir al menos una dirección para guardar.');
        }
      },
      savePhones() {
        if (this.phones.length > 0) {
          alert('Teléfonos guardados (demo)');
          this.phonesLoaded = true;
          this.activeTab = 3; // Mover a la siguiente pestaña
        } else {
          alert('Debe añadir al menos un teléfono para guardar.');
        }
      },
      saveJobs() {
        if (this.works.length > 0) {
          alert('Trabajos guardados (demo)');
          this.jobsLoaded = true;
          // Aquí podríamos finalizar el formulario o ir a una pantalla de confirmación
        } else {
          alert('Debe añadir al menos un trabajo para guardar.');
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
      },
      addPhone() {
        if (this.currentPhone.tipo_telefono && this.currentPhone.fecha_alta && this.currentPhone.nro_telefono && this.currentPhone.a_nombre_de && this.currentPhone.estado) {
          const newPhone = { ...this.currentPhone };
          if (!newPhone.id) {
            newPhone.id = this.phones.length > 0 ? Math.max(...this.phones.map(p => p.id || 0)) + 1 : 1;
          }
          const existingIndex = this.phones.findIndex(phone => phone.id === newPhone.id);
          if (existingIndex !== -1) {
            this.phones.splice(existingIndex, 1, newPhone);
          } else {
            this.phones.push(newPhone);
          }
          this.clearPhone();
        } else {
          alert('Por favor, complete todos los campos de teléfono antes de agregar.');
        }
      },
      clearPhone() {
        this.currentPhone = {
          id: null,
          tipo_telefono: '',
          fecha_alta: new Date().toISOString().slice(0, 10),
          nro_telefono: '',
          a_nombre_de: '',
          estado: 'Activo'
        };
      },
      editPhone(index) {
        this.currentPhone = { ...this.phones[index] };
      },
      removePhone(index) {
        if (confirm('¿Está seguro de que desea eliminar este teléfono?')) {
          this.phones.splice(index, 1);
        }
      },
      addWork() {
        if (this.currentWork.condicion_laboral && this.currentWork.fecha_ingreso && this.currentWork.empresa && this.currentWork.seccion && this.currentWork.sector_economico && this.currentWork.cargo) {
          const newWork = { ...this.currentWork };
          if (!newWork.id) {
            newWork.id = this.works.length > 0 ? Math.max(...this.works.map(w => w.id || 0)) + 1 : 1;
          }
          const existingIndex = this.works.findIndex(work => work.id === newWork.id);
          if (existingIndex !== -1) {
            this.works.splice(existingIndex, 1, newWork);
          } else {
            this.works.push(newWork);
          }
          this.clearWork();
        } else {
          alert('Por favor, complete todos los campos de trabajo antes de agregar.');
        }
      },
      clearWork() {
        this.currentWork = {
          id: null,
          condicion_laboral: '',
          fecha_ingreso: new Date().toISOString().slice(0, 10),
          empresa: '',
          seccion: '',
          sector_economico: '',
          cargo: '',
          actual: false
        };
      },
      editWork(index) {
        this.currentWork = { ...this.works[index] };
      },
      removeWork(index) {
        if (confirm('¿Está seguro de que desea eliminar este trabajo?')) {
          this.works.splice(index, 1);
        }
      },
      getTabStatus(index) {
        return true; // Todas las pestañas están siempre habilitadas
      },
      selectTab(index) {
        this.activeTab = index; // Permitir la selección de cualquier pestaña
      }
    }
  }
  </script>

  <style>
  @import 'leaflet/dist/leaflet.css';
  </style>