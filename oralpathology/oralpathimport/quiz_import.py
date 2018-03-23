import csv
import os
import uuid

from utilities import sqlutils, stringutils, globals


counter = 0
filename = "data/quiz_questions_bank.csv"
with open(os.path.abspath(filename), 'rU') as f:
    for row in csv.reader(f):
        if any(row) and counter > 0:
            questionID = str(uuid.uuid4())
            questionStem = row[0]
            print(questionID + " : " + questionStem)

            sql = "INSERT INTO quizquestions (questionID, questionStem) VALUES (%s, %s);"
            sqlutils.execMysqlQuery(sql, (questionID, questionStem))


            correctAnswer = row[1]
            print("Correct: " + correctAnswer)

            sql = "INSERT INTO quizquestionchoices (choiceID, fk_questionID, choiceText, isCorrect) "
            sql += "VALUES (%s, %s, %s, %s); "
            sqlutils.execMysqlQuery(sql, (str(uuid.uuid4()), questionID, correctAnswer, 'y'))



            incorrectAnswer1 = row[2]
            if incorrectAnswer1 != "":
                print("Incorrect: " + incorrectAnswer1)
                sql = "INSERT INTO quizquestionchoices (choiceID, fk_questionID, choiceText, isCorrect) "
                sql += "VALUES (%s, %s, %s, %s); "
                sqlutils.execMysqlQuery(sql, (str(uuid.uuid4()), questionID, incorrectAnswer1, 'n'))

            incorrectAnswer2 = row[3]
            if incorrectAnswer2 != "":
                print("Incorrect: " + incorrectAnswer2)
                sql = "INSERT INTO quizquestionchoices (choiceID, fk_questionID, choiceText, isCorrect) "
                sql += "VALUES (%s, %s, %s, %s); "
                sqlutils.execMysqlQuery(sql, (str(uuid.uuid4()), questionID, incorrectAnswer2, 'n'))

            incorrectAnswer3 = row[4]
            if incorrectAnswer3 != "":
                print("Incorrect: " + incorrectAnswer3)
                sql = "INSERT INTO quizquestionchoices (choiceID, fk_questionID, choiceText, isCorrect) "
                sql += "VALUES (%s, %s, %s, %s); "
                sqlutils.execMysqlQuery(sql, (str(uuid.uuid4()), questionID, incorrectAnswer3, 'n'))

            '''
            category1 = row[5]
            if category1 != "":
                print("Category 1: " + category1)

            category2 = row[6]
            if category2 != "":
                print("Category 2: " + category2)

            category3 = row[7]
            if category3 != "":
                print("Category 3: " + category3)
            '''

        counter = counter + 1  # Note - counter is only used to ignore the first row of the spreadsheet (contains column headings)


