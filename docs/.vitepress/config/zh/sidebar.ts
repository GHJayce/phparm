
import type {DefaultTheme} from 'vitepress'

import v1x from './1.x';

const config:DefaultTheme.Config['sidebar'] = {
  '/zh/1_x/': v1x,
}

export default config