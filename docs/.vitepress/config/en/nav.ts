import type { DefaultTheme } from 'vitepress'

const config: DefaultTheme.Config['nav'] = [
  {
    text: 'en文档版本',
    items: [
      { text: '1.x', link: '/en/1_x/' },
    ]
  }
]

export default config
