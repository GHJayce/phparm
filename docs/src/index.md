<script setup>
import { onMounted } from 'vue'
import { useRouter,useData,LocaleSpecificConfig } from 'vitepress'

const router = useRouter()

onMounted(() => {
console.log(useData(), router.route)
  // 检测浏览器语言
  const userLang = navigator.language || navigator.userLanguage
  // 简单判断，可根据需要细化
  if (userLang.startsWith('zh')) {
    // 跳转到中文首页
    router.go(router.route.path+'zh/')
  } else {
    // 默认跳转到英文首页
    router.go(router.route.path+'en/')
  }
})
</script>

<template>
  <div>正在重定向...</div>
</template>