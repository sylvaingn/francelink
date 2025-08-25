const fs = require('fs');
const path = require('path');
const readline = require('readline').createInterface({
    input: process.stdin,
    output: process.stdout
});

/**
 * @param {String} question
 * @returns {Promise<String>}
 */
const prompt = (question) => {
    return new Promise((resolve) => {
        readline.question(question, resolve);
    });
};

const TEMPLATE_FOLDER_NAME = 'block-tpl';
const TARGET_FOLDER_NAME='blocks';
const SCSS_TARGET_FOLDER='scss/blocks';
const JS_TARGET_FOLDER='js/blocks';

(async () => {
    if (!fs.existsSync(path.join('.', TEMPLATE_FOLDER_NAME))) { // Two checks?
        console.error('Le dossier source n\'existe pas.');
        process.exit(1);
    } else {
        if (!fs.existsSync(path.join('.', TARGET_FOLDER_NAME))) {
            fs.mkdirSync(path.join('.', TARGET_FOLDER_NAME));
        }

        if (!fs.existsSync(path.join('.', SCSS_TARGET_FOLDER))) {
            fs.mkdirSync(path.join('.', SCSS_TARGET_FOLDER));
        }

        if (!fs.existsSync(path.join('.', JS_TARGET_FOLDER))) {
            fs.mkdirSync(path.join('.', JS_TARGET_FOLDER));
        }
    }

    // ----------------------------------- Demande à l'utilisateur de fournir des infos sur le block
    const blockTitle = await prompt('Titre du block (Exemple Block) : ');
    const blockSlug = await prompt('Slug du block (exemple_block): ');
    const blockKeywords = (await prompt('Keywords : ')).split(' ').map(word => `"${word}"`).join(',');
    const folderBlockName = blockSlug.replace('_', '-');

    fs.mkdirSync(path.join(TARGET_FOLDER_NAME, TEMPLATE_FOLDER_NAME));
    fs.cpSync(
        TEMPLATE_FOLDER_NAME,
        path.join(TARGET_FOLDER_NAME, TEMPLATE_FOLDER_NAME),
        { recursive: true }
    );

    const scssBlockFolder = path.join(SCSS_TARGET_FOLDER, folderBlockName);
    const jsBlockFolder = path.join(JS_TARGET_FOLDER, folderBlockName);

    fs.mkdirSync(scssBlockFolder);
    fs.closeSync(fs.openSync(path.join(scssBlockFolder, `${folderBlockName}.scss`), 'w'));

    fs.mkdirSync(jsBlockFolder);
    fs.closeSync(fs.openSync(path.join(jsBlockFolder, `${folderBlockName}-js.js`), 'w'));

    const blockName = blockSlug.split('_').map(word => `${word.charAt(0).toUpperCase()}${word.slice(1)}`).join(' ');
    const blockNamespace = blockName.replace(' ', '_');

    fs.cpSync(
        path.join(TARGET_FOLDER_NAME, TEMPLATE_FOLDER_NAME),
        path.join(TARGET_FOLDER_NAME, folderBlockName),
        { recursive: true }
    );

    fs.rmSync(path.join(TARGET_FOLDER_NAME, TEMPLATE_FOLDER_NAME), { recursive: true, force: true });

    console.log(`\nLe dossier ${TARGET_FOLDER_NAME} a bien été créé en utilisant le template '${TEMPLATE_FOLDER_NAME}'.`);

    fs.readdirSync(path.join(TARGET_FOLDER_NAME, folderBlockName)).forEach(file => {
        const filePath = path.join(TARGET_FOLDER_NAME, folderBlockName, file);

        if (!fs.statSync(filePath).isFile()) {
            return;
        }

        const data = fs.readFileSync(filePath, 'utf8');

        const result = data
            .replace(/!!title!!/ug, blockTitle)
            .replace(/!!namespace!!/ug, blockNamespace)
            .replace(/!!name!!/ug, folderBlockName)
            .replace(/!!slug!!/ug, blockSlug)
            .replace(/!!keywords!!/ug, blockKeywords);

        fs.writeFileSync(filePath, result, 'utf8');
    });

    console.log('Remplacement terminé.');

    process.exit(0);
})();