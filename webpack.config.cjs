const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
module.exports = {
    entry: { app: ["./resources/js/app.js", "./resources/scss/app.scss"], admin: "./resources/scss/admin.scss" },
    output: {
        path: path.resolve(__dirname, "public/build"),
        filename: "js/[name].js",
        chunkFilename: "js/[name].chunk.js",
        clean: true,
    },
    module: {
        rules: [
            {
                test: /\.scss$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
            },
        ],
    },
    optimization: { splitChunks: { chunks: "all" } },
    plugins: [new MiniCssExtractPlugin({ filename: "css/[name].css", chunkFilename: "css/[name].chunk.css" })],
};
