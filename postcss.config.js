import purgecss from '@fullhuman/postcss-purgecss';
import cssnano from 'cssnano';

export default {
  plugins: [
    purgecss.default({ // <--- tambahkan .default
      content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
      ],
      safelist: [
        /^bg-/,
        /^text-/,
        /^btn-/,
        'show',
        'collapse',
        'collapsing'
      ],
    }),
    cssnano({ preset: 'default' }),
  ],
};
