import {defineAdditionalConfig, type DefaultTheme} from 'vitepress'

export default defineAdditionalConfig({
  description: 'Vite & Vue powered static site generator.',

  themeConfig: {
    nav: nav(),

    sidebar: {
      '/en/guide/': {base: '/en/guide/', items: sidebarGuide()},
      '/en/reference/': {base: '/en/reference/', items: sidebarReference()}
    },

    editLink: {
      pattern: 'https://github.com/vuejs/vitepress/edit/main/docs/:path',
      text: '在 GitHub 上编辑此页面'
    },

    footer: {
      message: '基于 MIT 许可发布',
      copyright: '版权所有 © 2019-至今 尤雨溪'
    },

    docFooter: {
      prev: 'prev page',
      next: 'next page'
    },

    outline: {
      label: '页面导航'
    },

    lastUpdated: {
      text: '最后更新于'
    },

    notFound: {
      title: '页面未找到',
      quote:
        '但如果你不改变方向，并且继续寻找，你可能最终会到达你所前往的地方。',
      linkLabel: '前往首页',
      linkText: '带我回首页'
    },

    langMenuLabel: '多语言',
    returnToTopLabel: '回到顶部',
    sidebarMenuLabel: '菜单',
    darkModeSwitchLabel: '主题',
    lightModeSwitchTitle: '切换到浅色模式',
    darkModeSwitchTitle: '切换到深色模式',
    skipToContentLabel: '跳转到内容'
  }
})


function nav(): DefaultTheme.NavItem[] {
  return [
    {
      text: 'Guide',
      link: '/guide/what-is-vitepress',
      activeMatch: '/guide/'
    },
    {
      text: 'Reference',
      link: '/reference/site-config',
      activeMatch: '/reference/'
    },
    {
      text: '版本',
      items: [
        {
          text: '1.6.4',
          link: 'https://vuejs.github.io/vitepress/v1/'
        },
        {
          text: 'Changelog',
          link: 'https://github.com/vuejs/vitepress/blob/main/CHANGELOG.md'
        },
        {
          text: 'Contributing',
          link: 'https://github.com/vuejs/vitepress/blob/main/.github/contributing.md'
        }
      ]
    }
  ]
}

function sidebarGuide(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: 'Introduction',
      collapsed: false,
      items: [
        {text: 'What is VitePress?', link: 'what-is-vitepress'},
        {text: 'Getting Started', link: 'getting-started'},
        {text: 'Routing', link: 'routing'},
        {text: 'Deploy', link: 'deploy'}
      ]
    },
    {
      text: 'Writing',
      collapsed: false,
      items: [
        {text: 'Markdown Extensions', link: 'markdown'},
        {text: 'Asset Handling', link: 'asset-handling'},
        {text: 'Frontmatter', link: 'frontmatter'},
        {text: 'Using Vue in Markdown', link: 'using-vue'},
        {text: 'Internationalization', link: 'i18n'}
      ]
    },
    {
      text: 'Customization',
      collapsed: false,
      items: [
        {text: 'Using a Custom Theme', link: 'custom-theme'},
        {
          text: 'Extending the Default Theme',
          link: 'extending-default-theme'
        },
        {text: 'Build-Time Data Loading', link: 'data-loading'},
        {text: 'SSR Compatibility', link: 'ssr-compat'},
        {text: 'Connecting to a CMS', link: 'cms'}
      ]
    },
    {
      text: 'Experimental',
      collapsed: false,
      items: [
        {text: 'MPA Mode', link: 'mpa-mode'},
        {text: 'Sitemap Generation', link: 'sitemap-generation'}
      ]
    },
    {text: 'Config & API Reference', base: '/reference/', link: 'site-config'}
  ]
}

function sidebarReference(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: 'Reference',
      items: [
        {text: 'Site Config', link: 'site-config'},
        {text: 'Frontmatter Config', link: 'frontmatter-config'},
        {text: 'Runtime API', link: 'runtime-api'},
        {text: 'CLI', link: 'cli'},
        {
          text: 'Default Theme',
          base: '/reference/default-theme-',
          items: [
            {text: 'Overview', link: 'config'},
            {text: 'Nav', link: 'nav'},
            {text: 'Sidebar', link: 'sidebar'},
            {text: 'Home Page', link: 'home-page'},
            {text: 'Footer', link: 'footer'},
            {text: 'Layout', link: 'layout'},
            {text: 'Badge', link: 'badge'},
            {text: 'Team Page', link: 'team-page'},
            {text: 'Prev / Next Links', link: 'prev-next-links'},
            {text: 'Edit Link', link: 'edit-link'},
            {text: 'Last Updated Timestamp', link: 'last-updated'},
            {text: 'Search', link: 'search'},
            {text: 'Carbon Ads', link: 'carbon-ads'}
          ]
        }
      ]
    }
  ]
}

function searchOptions(): Partial<DefaultTheme.AlgoliaSearchOptions> {
  return {
    placeholder: '搜索文档',
    translations: {
      button: {
        buttonText: '搜索文档',
        buttonAriaLabel: '搜索文档'
      },
      modal: {
        searchBox: {
          clearButtonTitle: '清除查询条件',
          clearButtonAriaLabel: '清除查询条件',
          closeButtonText: '关闭',
          closeButtonAriaLabel: '关闭',
          placeholderText: '搜索文档',
          placeholderTextAskAi: '向 AI 提问：',
          placeholderTextAskAiStreaming: '回答中...',
          searchInputLabel: '搜索',
          backToKeywordSearchButtonText: '返回关键字搜索',
          backToKeywordSearchButtonAriaLabel: '返回关键字搜索'
        },
        startScreen: {
          recentSearchesTitle: '搜索历史',
          noRecentSearchesText: '没有搜索历史',
          saveRecentSearchButtonTitle: '保存至搜索历史',
          removeRecentSearchButtonTitle: '从搜索历史中移除',
          favoriteSearchesTitle: '收藏',
          removeFavoriteSearchButtonTitle: '从收藏中移除',
          recentConversationsTitle: '最近的对话',
          removeRecentConversationButtonTitle: '从历史记录中删除对话'
        },
        errorScreen: {
          titleText: '无法获取结果',
          helpText: '你可能需要检查你的网络连接'
        },
        noResultsScreen: {
          noResultsText: '无法找到相关结果',
          suggestedQueryText: '你可以尝试查询',
          reportMissingResultsText: '你认为该查询应该有结果？',
          reportMissingResultsLinkText: '点击反馈'
        },
        resultsScreen: {
          askAiPlaceholder: '向 AI 提问： '
        },
        askAiScreen: {
          disclaimerText: '答案由 AI 生成，可能不准确，请自行验证。',
          relatedSourcesText: '相关来源',
          thinkingText: '思考中...',
          copyButtonText: '复制',
          copyButtonCopiedText: '已复制！',
          copyButtonTitle: '复制',
          likeButtonTitle: '赞',
          dislikeButtonTitle: '踩',
          thanksForFeedbackText: '感谢你的反馈！',
          preToolCallText: '搜索中...',
          duringToolCallText: '搜索 ',
          afterToolCallText: '已搜索',
          aggregatedToolCallText: '已搜索'
        },
        footer: {
          selectText: '选择',
          submitQuestionText: '提交问题',
          selectKeyAriaLabel: 'Enter 键',
          navigateText: '切换',
          navigateUpKeyAriaLabel: '向上箭头',
          navigateDownKeyAriaLabel: '向下箭头',
          closeText: '关闭',
          backToSearchText: '返回搜索',
          closeKeyAriaLabel: 'Esc 键',
          poweredByText: '搜索提供者'
        }
      }
    }
  }
}
