const path = require('path');

console.log("Reading webpack");

module.exports = {
  entry: './src/index.js',  // El archivo de entrada principal de tu aplicación
  output: {
    path: path.resolve(__dirname, 'dist'),  // Directorio donde se generará el bundle
    filename: 'bundle.js',  // Nombre del archivo generado
    publicPath: '/admin/',  // Ruta pública desde la cual los archivos serán servidos (si tu aplicación está en /admin/)
  },
  resolve: {
    alias: {
      'react': 'preact/compat',
      'react-dom': 'preact/compat'
    }
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,  // Esto asegura que Webpack maneje archivos .js y .jsx
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',  // Cargar y compilar archivos usando Babel
        },
      },
      {
        test: /\.css$/,  // Para manejar archivos CSS
        use: ['style-loader', 'css-loader'],
      },
    ],
  },
  devServer: {
    contentBase: path.join(__dirname, 'dist'),  // Directorio desde el cual el servidor servirá archivos estáticos
    compress: true,  // Habilitar la compresión gzip
    port: 8080,  // El puerto en el que el servidor de desarrollo estará corriendo
    publicPath: '/admin/',  // Asegúrate de que coincida con donde esperas servir tus archivos
    historyApiFallback: true,  // Para asegurar que todas las rutas sean manejadas por el index.html
    host: '0.0.0.0',  // Para que sea accesible desde otras máquinas
  },
};
