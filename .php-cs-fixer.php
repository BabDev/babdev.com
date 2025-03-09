<?php

return new PhpCsFixer\Config()
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@PER-CS' => true,
        '@PHP84Migration' => true,
        '@PHP82Migration:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        'align_multiline_comment' => true,
        'array_indentation' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'case',
                'continue',
                'for',
                'foreach',
                'if',
                'return',
                'switch',
                'throw',
                'try',
                'while',
            ],
        ],
        'cast_spaces' => [
            'space' => 'single',
        ],
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'declare_strict_types' => false,
        'dir_constant' => true,
        'function_to_constant' => true,
        'increment_style' => [
            'style' => 'post',
        ],
        'is_null' => true,
        'linebreak_after_opening_tag' => true,
        'magic_constant_casing' => true,
        'method_chaining_indentation' => true,
        'modernize_types_casting' => true,
        'native_constant_invocation' => true,
        'native_function_casing' => true,
        'native_function_invocation' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_mixed_echo_print' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_null_property_initialization' => true,
        'no_short_bool_cast' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_singleline' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_align' => true,
        'phpdoc_scalar' => true,
        'protected_to_private' => true,
        'set_type_to_cast' => true,
        'simplified_null_return' => true,
        'single_line_empty_body' => true,
        'spaces_inside_parentheses' => false,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => [
                'arguments',
                'arrays',
                'parameters',
            ],
        ],
        'type_declaration_spaces' => true,
        'yoda_style' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        new PhpCsFixer\Finder()
            ->notPath('bootstrap/cache')
            ->notPath('config')
            ->notPath('node_modules')
            ->notPath('storage')
            ->notPath('vendor')
            ->in(__DIR__)
            ->name('*.php')
            ->notName('*.blade.php')
            ->notName('_ide_helper.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
    );
