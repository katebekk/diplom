#!/usr/bin python
from Builders.CheckingDrawing.CheckingDrawing import CheckingDrawing as cd
import cv2
import os
from sys import argv

dict = []
for arg in argv:
    dict.append(arg)

reference_img = dict[1]
learner_img = dict[2]

result_img, message, percent = cd.checkDrawing(cd, reference_img, learner_img)
path = '/var/www/diplom/public/uploads/resultImages/'+ os.path.basename(reference_img)
res = cv2.imwrite(path , result_img)

print("{\"img\":\""+ os.path.basename(reference_img) +"\",\"message\":\""+ message +"\",\"percent\":\""+ str(percent) +"\"}")
