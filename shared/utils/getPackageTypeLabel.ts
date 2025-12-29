import type {PackageType} from '#shared/types/packages'

export default function (type: PackageType) {
    switch (type) {
        case 'laravel-package':
            return 'Laravel Package'

        case 'php-package':
            return 'PHP Package'

        case 'sylius-plugin':
            return 'Sylius Plugin'

        case 'symfony-bundle':
            return 'Symfony Bundle'
    }
}
