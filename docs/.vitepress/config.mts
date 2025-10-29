import {
  defineConfig,
  resolveSiteDataByRoute,
  type HeadConfig
} from 'vitepress'
import projectInfo from './info.mjs'
import dotenv from 'dotenv'

dotenv.config()
const env = process.env.ENV || 'prod'

export default defineConfig({

  vite: {
    resolve: {
      alias: {}
    },
    plugins: [],
    experimental: {}
  },

  base: env === 'prod' ? '/' + projectInfo.name : '',
  // srcDir: './src',
  title: projectInfo.name,

  rewrites: {
    // 'zh/:rest*': ':rest*'
  },

  lastUpdated: true,
  cleanUrls: true,
  metaChunk: true,

  markdown: {
    math: false,
    codeTransformers: [
      {
        postprocess(code) {
          return code.replace(/\[\!\!code/g, '[!code')
        }
      }
    ]
  },

  sitemap: {
    hostname: projectInfo.docUrl,
    transformItems(items) {
      return items.filter((item) => item.url.indexOf('migration') === -1)
    }
  },

  head: [
    ['meta', {name: 'theme-color', content: '#5f67ee'}],
    ['meta', {property: 'og:type', content: 'website'}],
    ['meta', {property: 'og:site_name', content: projectInfo.nameWithAuthor}],
    ['meta', {property: 'og:url', content: projectInfo.docUrl}],
    [
      'script',
      {
        src: 'https://cdn.usefathom.com/script.js',
        'data-site': 'AZBRSFGG',
        'data-spa': 'auto',
        defer: ''
      }
    ]
  ],

  themeConfig: {
    socialLinks: [
      {icon: 'github', link: projectInfo.githubUrl}
    ],

    search: {
      provider: 'local'
    },

    outline: {
      level: 'deep',
    },
  },

  locales: {
    zh: {label: '简体中文', lang: 'zh-CN', dir: 'ltl'},
    en: {label: 'English', lang: 'en', dir: 'ltl'},
  },

  transformPageData: (pageData, ctx) => {
    const site = resolveSiteDataByRoute(
      ctx.siteConfig.site,
      pageData.relativePath
    )
    const title = `${pageData.title || site.title} | ${pageData.description || site.description}`
    ;((pageData.frontmatter.head ??= []) as HeadConfig[]).push(
      ['meta', {property: 'og:locale', content: site.lang}],
      ['meta', {property: 'og:title', content: title}]
    )
  }
})