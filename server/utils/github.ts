import { Octokit } from '@octokit/rest'

let octokit: Octokit | null = null

export function getGitHubClient() {
    if (!octokit) {
        const config = useRuntimeConfig()

        octokit = new Octokit({
            auth: config.githubToken,
        })
    }

    return octokit
}

export async function fetchRepositoryData(owner: string, repo: string) {
    try {
        const { data } = await getGitHubClient().repos.get({
            owner,
            repo,
        })

        return {
            stars: data.stargazers_count,
            language: data.language,
            topics: data.topics || [],
            description: data.description,
        }
    } catch (error) {
        console.error(`Failed to fetch repository data for ${owner}/${repo}:`, error)

        return null
    }
}

export async function fetchRepositoryFile(owner: string, repo: string, path: string, ref: string) {
    try {
        const { data } = await getGitHubClient().repos.getContent({
            owner,
            repo,
            path,
            ref,
        })

        if ('content' in data && data.encoding === 'base64') {
            return Buffer.from(data.content, 'base64').toString('utf-8')
        }

        return null
    } catch (error) {
        console.error(`Failed to fetch ${path} from ${owner}/${repo}@${ref}`, error)

        return null
    }
}
