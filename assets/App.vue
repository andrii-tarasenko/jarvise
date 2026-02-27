<template>
  <va-layout style="height: 100vh;">
    <template #top>
      <va-navbar color="primary">
        <template #left>
          <va-button preset="secondary" icon="menu" @click="isSidebarVisible = !isSidebarVisible" />
        </template>
        <template #center>
          <va-navbar-item class="font-bold text-lg">Jarvise</va-navbar-item>
        </template>
      </va-navbar>
    </template>

    <template #left>
      <va-sidebar v-model="isSidebarVisible">
        <va-sidebar-item active>
          <va-sidebar-item-content>
            <va-icon name="dashboard" />
            <va-sidebar-item-title>Dashboard</va-sidebar-item-title>
          </va-sidebar-item-content>
        </va-sidebar-item>
      </va-sidebar>
    </template>

    <template #content>
      <main class="p-4">
        <router-view></router-view>
      </main>
    </template>
  </va-layout>
</template>

<script setup>
import { ref } from 'vue'

const isSidebarVisible = ref(true)
</script>

<style>
/* Загальні стилі для обнулення відступів */
body, html {
  margin: 0;
  padding: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
</style>
