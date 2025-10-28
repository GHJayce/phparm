import fs from 'node:fs'
import path from 'node:path'

interface authors {
  name: string;
  homepage: string;
  email: string;
}

interface infoStruct {
  name: string;
  nameWithAuthor: string;
  authors: authors[];
  githubUrl: string;
  docUrl: string;
  changelogUrl: string;
  issueUrl: string;
}

const jsonPath: string = path.resolve(__dirname, '../public/info.json')
const info: infoStruct = JSON.parse(fs.readFileSync(jsonPath, 'utf8'))

export default info;