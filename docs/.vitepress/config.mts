import {
  defineConfig,
  resolveSiteDataByRoute,
  type HeadConfig
} from 'vitepress'

import fs from 'node:fs'
import path from 'node:path'

const constJsonPath = path.resolve('docs', 'const.json')
const constConfig = JSON.parse(fs.readFileSync(constJsonPath, 'utf8'))

export default defineConfig({
  // base: '/weapon/zh/',
  // srcDir: './src',
  title: 'PHPArm',

  rewrites: {
    'zh/:rest*': ':rest*'
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
    ],
    config: (md) => {
      console.log(md)
    }
  },

  sitemap: {
    hostname: constConfig.docsUrl,
    transformItems(items) {
      return items.filter((item) => item.url.indexOf('migration') === -1)
    }
  },

  head: [
    // [
    //   'link',
    //   {rel: 'icon', type: 'image/svg+xml', href: '/logo-mini.svg'}
    // ],
    // [
    //   'link',
    //   {rel: 'icon', type: 'image/png', href: '/logo-mini.png'}
    // ],
    ['meta', {name: 'theme-color', content: '#5f67ee'}],
    ['meta', {property: 'og:type', content: 'website'}],
    ['meta', {property: 'og:site_name', content: constConfig.nameWithAuthor}],
    // [
    //   'meta',
    //   {
    //     property: 'og:image',
    //     content: 'https://domain.com/-og.jpg'
    //   }
    // ],
    ['meta', {property: 'og:url', content: constConfig.docsUrl}],
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
    // logo: {src: '/logo-mini.svg', width: 24, height: 24},

    socialLinks: [
      {icon: 'github', link: constConfig.githubUrl}
    ],

    search: {
      // provider: 'local'
      provider: 'algolia',
      options: {
        appId: '8J64VVRP8K',
        apiKey: '52f578a92b88ad6abde815aae2b0ad7c',
        indexName: 'vitepress',
        askAi: 'YaVSonfX5bS8'
      }
    },
  },

  locales: {
    root: {label: '简体中文', lang: 'zh', dir: 'ltr'},
    en: {label: 'English', lang: 'en', dir: 'ltr'},
  },

  vite: {
    resolve: {
      alias: {
        '@': path.resolve(__dirname, '../')
      }
    },
    plugins: [],
    experimental: {}
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