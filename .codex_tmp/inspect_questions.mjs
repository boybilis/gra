import fs from "node:fs/promises";
import { FileBlob, SpreadsheetFile } from "@oai/artifact-tool";

const sourcePath = "C:/Users/yzza/Documents/boybi websites/gra/NCLEX SAMPLE QUESTIONNAIRES (1).xlsx";
const outputDir = "C:/xampp/htdocs/gra/.codex_tmp/updated_question_previews";
await fs.mkdir(outputDir, { recursive: true });

const workbook = await SpreadsheetFile.importXlsx(await FileBlob.load(sourcePath));
const sheetSummary = await workbook.inspect({
  kind: "sheet",
  include: "id,name",
  maxChars: 12000,
});
console.log("SHEETS\n" + sheetSummary.ndjson);

const compact = await workbook.inspect({
  kind: "workbook,sheet,table",
  maxChars: 30000,
  tableMaxRows: 40,
  tableMaxCols: 12,
  tableMaxCellChars: 500,
});
console.log("CONTENT\n" + compact.ndjson);

for (const sheet of workbook.worksheets.items) {
  const used = sheet.getUsedRange();
  if (used) {
    const preview = await workbook.render({
      sheetName: sheet.name,
      autoCrop: "all",
      scale: 1,
      format: "png",
    });
    const safeName = sheet.name.replace(/[^a-z0-9_-]+/gi, "_");
    await fs.writeFile(`${outputDir}/${safeName}.png`, new Uint8Array(await preview.arrayBuffer()));
  }
}
