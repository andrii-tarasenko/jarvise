<template>
    <div class="mb-4">
        <h1 class="text-2xl font-bold">Grid Dashboard</h1>
        <p class="text-gray-500">Real-time data from the inverter.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <va-card color="primary" gradient>
            <va-card-content>
                <h2 class="text-xl">Grid Power</h2>
                <p class="text-3xl font-bold">{{ latestReading ? latestReading.gridPower + ' W' : 'Loading...' }}</p>
            </va-card-content>
        </va-card>

        <va-card color="warning" gradient>
            <va-card-content>
                <h2 class="text-xl">Solar Power</h2>
                <p class="text-3xl font-bold">{{ latestReading ? latestReading.solarPower + ' W' : 'Loading...' }}</p>
            </va-card-content>
        </va-card>

        <va-card color="success" gradient>
            <va-card-content>
                <h2 class="text-xl">Tariff</h2>
                <p class="text-3xl font-bold">{{
                        latestReading ? latestReading.totalSolarPrice + ' ₴' : 'Loading...'
                    }}</p>
            </va-card-content>
        </va-card>
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
            />
        </va-card-content>
    </va-card>
</template>

<script setup>
import {ref, onMounted, computed} from 'vue'

const readings = ref([])
const loading = ref(true)

const columns = [

    {key: 'gridPower', label: 'Grid (W)', sortable: true},
    {key: 'solarPower', label: 'Solar (W)', sortable: true},
    {key: 'totalSolarPrice', label: 'Total Solar', sortable: true},
    {key: 'totalGridPrice', label: 'Total Grid', sortable: true},
    {key: 'createdAt', label: 'Time', sortable: true},
]

const latestReading = computed(() => {
    return readings.value.length > 0 ? readings.value[0] : null
})

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
})
</script>
