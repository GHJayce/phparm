import { defineConfig } from 'vitepress'
// import zhSidebarConfig from './config/zh/sidebar'
// import enSidebarConfig from './config/en/sidebar'
// import zhNavConfig from './config/zh/nav'
// import enNavConfig from './config/en/nav'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  // base: '/weapon/zh/',
  title: "Weapon",
  description: "PHP arsenal.",
  lastUpdated: true,
  cleanUrls: true,
  metaChunk: true,
  locales: {
    root: { label: '简体中文', lang: 'zh' },
    en: { label: 'English', lang: 'en' },
  },
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    editLink: {
      pattern: (pageData) => {
        const filePath = pageData.filePath
        return `https://github.com/GHJayce/weapon/edit/master/docs/src/${filePath}`
      }
    },
    outline: {
      level: 'deep',
      label: '目录'
    },
    socialLinks: [
      { icon: 'github', link: 'https://github.com/GHJayce/weapon' }
    ],
    footer: {
      message: 'Released under the <a href="https://github.com/GHJayce/weapon/blob/master/LICENSE">MIT License</a>.',
      copyright: 'Copyright © 2018-present <a href="https://github.com/GHjayce">GHJayce</a>'
    }
  }
})
