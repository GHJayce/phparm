import { defineConfig } from 'vitepress'
import zhSidebarConfig from './config/zh/sidebar'
import enSidebarConfig from './config/en/sidebar'
import zhNavConfig from './config/zh/nav'
import enNavConfig from './config/en/nav'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  // base: '/weapon/zh/',
  srcDir: "src",
  title: "Weapon",
  description: "There's always the PHP weapon you want.",
  lastUpdated: true,
  cleanUrls: true,
  locales: {
    root: {
      label: '中文',
      lang: 'zh',
      themeConfig: {
        outline: {
          label: '目录',
        },
        nav: zhNavConfig,
        sidebar: zhSidebarConfig
      }
    },
    en: {
      label: 'English',
      lang: 'en',
      themeConfig: {
        outline: {
          label: 'On this page',
        },
        nav: enNavConfig,
        sidebar: enSidebarConfig
      }
    }
  },
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    editLink: {
      pattern: (pageData) => {
        const filePath = pageData.filePath
        return `https://github.com/GHJayce/weapon/edit/master/docs/src/${filePath}`
      }
    },
    // nav: zhNavConfig,
    // sidebar: zhSidebarConfig,
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
