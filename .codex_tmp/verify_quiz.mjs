import fs from "node:fs/promises";
import vm from "node:vm";

const source = await fs.readFile("C:/xampp/htdocs/gra/practice-quizzes.php", "utf8");
const start = source.indexOf("const questions = [") + "const questions = ".length;
const end = source.indexOf("\n      ];", start) + "\n      ]".length;
const questions = vm.runInNewContext(source.slice(start, end));
const expected = [[3],[1,3,5],[2,3,4,5],[3],[0,1,3],[1],[0,1,4,5,6],[0],[1,2],[2],[0,1,2,5,6,7],[0],[3],[0],[0,1,3,4]];
const keysMatch = questions.every((question, index) => JSON.stringify(question.correct) === JSON.stringify(expected[index]));
const invalidAnswers = questions.filter((question) => question.correct.some((answer) => answer < 0 || answer >= question.choices.length));
console.log(JSON.stringify({
  total: questions.length,
  multipleChoice: questions.filter((question) => question.type === "single").length,
  sata: questions.filter((question) => question.type === "multiple").length,
  keysMatch,
  invalidAnswerKeys: invalidAnswers.length,
  chartProperties: questions.filter((question) => "chartImage" in question).length,
}, null, 2));
