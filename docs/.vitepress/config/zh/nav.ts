import type { DefaultTheme } from 'vitepress'

const config: DefaultTheme.Config['nav'] = [
  {
    text: '文档版本',
    items: [
      { text: '1.x', link: '/zh/1_x/' },
    ]
  }
]

export default config
