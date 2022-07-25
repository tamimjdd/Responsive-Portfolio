module.exports = {
    content: [
      './resources/views/**/*.blade.php',
      './resources/css/**/*.css',
      './resources/sass/**/*.scss',
      './resources/**/*.vue',
    ],
    theme: {
      extend: {}
    },
    variants: {},
    plugins: [
      require('@tailwindcss/ui'),
      require('@tailwindcss/line-clamp'),
    ]

  }
