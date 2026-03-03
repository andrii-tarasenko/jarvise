<template>
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Grid Dashboard</h1>
        <p class="text-gray-500">Real-time data from the inverter.</p>
    </div>
    <h2 class="text-xl font-bold mb-3">Grid status</h2>
    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 mb-4">
        <va-card :color="latestReading?.isGridActive ? 'success' : 'danger'" gradient>
            <va-card-content>
                <h2 class="text-xl">Grid Status</h2>
                <p class="text-4xl font-bold">{{
                        latestReading ? (latestReading.isGridActive ? 'Online' : 'Offline') : 'Loading...'
                    }}</p>
            </va-card-content>
        </va-card>
        <va-card color="primary" gradient>
            <va-card-content>
                <h2 class="text-xl">Voltage</h2>
                <p class="text-4xl font-bold">{{ stats ? stats.voltage + ' V' : 'Loading...' }}</p>
            </va-card-content>
        </va-card>

        <va-card color="warning" gradient>
            <va-card-content>
                <h2 class="text-xl">Frequency</h2>
                <p class="text-4xl font-bold">{{ stats ? stats.frequency + ' Hz' : 'Loading...' }}</p>
            </va-card-content>
        </va-card>
    </div>

    <div class="mb-4">
      <h2 class="text-xl font-bold mb-3">Energy Statistics</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <va-card>
          <va-card-content>
            <h3 class="text-lg text-gray-500">Today</h3>
            <p class="text-2xl font-bold text-primary">{{ stats ? stats.energyToday + ' kWh/h' : 'Loading...' }}</p>
          </va-card-content>
        </va-card>

        <va-card>
          <va-card-content>
            <h3 class="text-lg text-gray-500">This Month</h3>
            <p class="text-2xl font-bold text-success">{{ stats ? stats.energyMonth + ' kWh/h' : 'Loading...' }}</p>
          </va-card-content>
        </va-card>

        <va-card>
          <va-card-content>
            <h3 class="text-lg text-gray-500">All Time</h3>
            <p class="text-2xl font-bold text-warning">{{ stats ? stats.energyTotal + ' kWh/h' : 'Loading...' }}</p>
          </va-card-content>
        </va-card>
      </div>
    </div>

    <va-card>
        <va-card-title>Recent Readings</va-card-title>
        <va-card-content>
            <div v-if="loading" class="flex justify-center p-4">
                <va-progress-circle indeterminate/>
            </div>
            <va-data-table
                v-else
                :items="readings"
                :columns="columns"
                striped
            >
                <template #cell(isGridActive)="{ rowData }">
                    <va-badge
                        :text="rowData.isGridActive ? 'Online' : 'Offline'"
                        :color="rowData.isGridActive ? 'success' : 'danger'"
                    />
                </template>
            </va-data-table>
        </va-card-content>
    </va-card>
</template>

<script setup>
import {ref, onMounted, computed} from 'vue'

const readings = ref([])
const stats = ref(null)
const loading = ref(true)

const columns = [
    {key: 'gridPower', label: 'Grid (W)', sortable: true},
    {key: 'voltage', label: 'Voltage (V)', sortable: true},
    {key: 'current', label: 'Current (A)', sortable: true},
    {key: 'energy', label: 'Energy', sortable: true},
    {key: 'power_f', label: 'Power factor', sortable: true},
    {key: 'solarPower', label: 'Solar (W)', sortable: true},
    {key: 'createdAt', label: 'Time', sortable: true},
]

const latestReading = computed(() => {
    return readings.value.length > 0 ? readings.value[0] : null
})

const fetchStats = async () => {
    try {
        const response = await fetch('/api/v1/grid/stats')
        stats.value = await response.json()
    } catch (e) {
        console.error('Failed to fetch stats', e)
    }
}

const fetchReadings = async () => {
    try {
        const response = await fetch('/api/v1/grid/readings?limit=10')
        readings.value = await response.json()
    } catch (e) {
        // console.error('Failed to fetch readings', e)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchReadings()
    fetchStats()
})
</script>
