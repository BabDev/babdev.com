import type { Package, PackageVersion } from '#shared/types/packages'

export default function (pkg: Package): PackageVersion | undefined {
    if (pkg.versions.length === 0) {
        return undefined
    }

    return pkg.versions.find(version => version.released) || pkg.versions[0]
}
