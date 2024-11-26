<?php
function my_custom_block_styles()
{
    // Register custom style for the core/columns block
    register_block_style(
        'core/columns',
        array(
            'name'         => 'hero-pattern',
            'label'        => 'Hero Pattern',
            'inline_style' => '
                .is-style-hero-pattern {
                    width: 100%;
                    gap: 0;
                    padding: 0;
                    margin: 0;
                    flex-wrap: wrap !important;
                }
                .is-style-hero-pattern .wp-block-column {
                    padding: 0;
                    min-width: 500px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }
                    @media (max-width: 500px) {
                        .is-style-hero-pattern .wp-block-column {
                            min-width: 100%;
                        }
                    }
                .is-style-hero-pattern .wp-block-column:first-child {
                    padding-left: 10%;
                    padding-right: 2rem;
                    flex-basis: 20.1%;
                }
            ',
        )
    );

    // Register a new custom style for the core/image block
    register_block_style(
        'core/image',
        array(
            'name'         => 'custom-image-pattern',
            'label'        => 'Custom Image Pattern',
            'inline_style' => '
                .is-style-custom-image-pattern {
                    margin: 0;
                    padding: 0;
                    height: 100%;
                }
                .is-style-custom-image-pattern img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: right;
                }
            ',
        )
    );

    // Register a new custom style for the core/title block
    register_block_style(
        'core/heading',
        array(
            'name'         => 'custom-title-pattern',
            'label'        => 'Custom Title Pattern',
            'inline_style' => '
                .is-style-custom-title-pattern {
                    line-height: 65px;
                    font-size: 4.5vw;
                }
            ',
        )
    );
    // Register a new custom style for the core/paragraph block
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'custom-paragraph-pattern',
            'label'        => 'Custom Paragraph Pattern',
            'inline_style' => '
                .is-style-custom-paragraph-pattern {
                    line-height: 28.8px;
                    max-width: 600px;
                }
            ',
        )
    );
    // Register a new custom style for the core/buttons block
    register_block_style(
        'core/buttons',
        array(
            'name'         => 'custom-buttons-pattern',
            'label'        => 'Custom Buttons Pattern',
            'inline_style' => '
                    .is-style-custom-buttons-pattern {
                        margin: 53px 0;
                        gap: 33px;
                    }
                ',
        )
    );
    // Register a new custom style for the core/button block
    register_block_style(
        'core/button',
        array(
            'name'         => 'custom-button-pattern',
            'label'        => 'Custom Button Pattern',
            'inline_style' => '
                .is-style-custom-button-pattern {
                    line-height: 24px;
                    width: 164px;
                    height: 57px;
                    position: relative;
                }
                .is-style-custom-button-pattern a {
                    padding: 0;
                    height: 100%;
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    position: absolute;
                }
                .is-style-custom-button-pattern:before {
                    content: "";
                    background: #fff;
                    position: absolute;
                    left: 5px;
                    top: 4px;
                    width: 100%;
                    height: 100%;
                    z-index: 0;
                }
            ',
        )
    );
    // Register a new custom style for the core/button block 2
    register_block_style(
        'core/button',
        array(
            'name'         => 'custom-button-pattern-2',
            'label'        => 'Custom Button Pattern 2',
            'inline_style' => '
                .is-style-custom-button-pattern-2 {
                    line-height: 24px;
                    width: 164px;
                    height: 57px;
                    margin-left: 33px;
                    position: relative;
                }
                .is-style-custom-button-pattern-2 a {
                    padding: 0;
                    height: 100%;
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    position: absolute;
                }
                .is-style-custom-button-pattern-2:before {
                    content: "";
                    background: #1A35FF;
                    position: absolute;
                    left: 5px;
                    top: 4px;
                    width: 100%;
                    height: 100%;
                    z-index: 0;
                }
            ',
        )
    );
}
add_action('init', 'my_custom_block_styles');
