import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import { readdirSync,lstatSync } from 'fs';
import { resolve } from 'path';


function getFilesFromDir(dir, fileTypes) {
    const filesToReturn = [];

    function walkDir(currentPath) {

        if(lstatSync(currentPath).isFile()){
            filesToReturn.push(currentPath);
            return;
        }

        const files = readdirSync(currentPath);
        for (let i in files) {
            const curFile = resolve(currentPath, files[i]);
            if(lstatSync(curFile).isDirectory()){
                walkDir(curFile);
                continue;
            }
            filesToReturn.push(curFile);
        }
    }

    walkDir(resolve(__dirname, dir));
    return filesToReturn;
}

const pageStyles = getFilesFromDir('./resources/css', ['css', 'scss']);
const js = getFilesFromDir('./resources/js',['js']);


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                ...pageStyles, // Spread the array of page styles
               ...js,
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
