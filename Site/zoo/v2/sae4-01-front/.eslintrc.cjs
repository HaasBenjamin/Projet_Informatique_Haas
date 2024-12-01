module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'plugin:react/recommended',
    'airbnb',
    "prettier",
  ],
  parserOptions: {
    ecmaFeatures: {
      jsx: true,
    },
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'react',
    "prettier",
  ],
  rules: {
    "prettier/prettier": ["error"],
    "react/require-default-props": [2, { functions: "defaultArguments" }],
    "jsx-a11y/label-has-associated-control": [2, { depth: 2 }],
  },
};
