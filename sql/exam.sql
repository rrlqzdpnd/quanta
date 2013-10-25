INSERT INTO choices (choiceid, choicetext) VALUES (1,'500');
INSERT INTO choices (choiceid, choicetext) VALUES (2,'50');
INSERT INTO choices (choiceid, choicetext) VALUES (3,'0.5');
INSERT INTO choices (choiceid, choicetext) VALUES (4,'5');

INSERT INTO questions(questionid, question) VALUES (1, 'If k = 2x10<sup>-2</sup>, then what does the expression 1/k equal to?');

INSERT INTO questionchoices (questionid, choiceid) VALUES (1,1);
INSERT INTO questionchoices (questionid, choiceid) VALUES (1,2);
INSERT INTO questionchoices (questionid, choiceid) VALUES (1,3);
INSERT INTO questionchoices (questionid, choiceid) VALUES (1,4);

INSERT INTO questionanswers (questionid, choiceid) VALUES (1,2);

INSERT INTO categories (categoryid, category, description) VALUES (1,'P','practice math for testing.');

INSERT INTO questiongroups (questionid, categoryid) VALUES (1,1);
