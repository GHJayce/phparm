<script setup>
import { onMounted } from 'vue'
import { useRouter,useData } from 'vitepress'

const router = useRouter()

onMounted(() => {
  const userLang = navigator.language || navigator.userLanguage
  if (userLang.startsWith('zh')) {
    router.go(router.route.path+'zh/')
  } else {
    router.go(router.route.path+'en/')
  }
})
</script>

<template>
  <div>正在重定向...</div>
</template>