from Builders.TrainingGroup.Pair import Pair

class TrainingGroup:
    __dir = "src/Images/training_group/"
    __training_group = None

    def __init__(self):
        self.__training_group = [
            Pair(self.__dir + "img1_1.png", self.__dir + "img1_2.png"),
            Pair(self.__dir + "img2_1.png", self.__dir + "img2_2.png"),
            Pair(self.__dir + "img3_1.png", self.__dir + "img3_2.png"),
            Pair(self.__dir + "img4_1.png", self.__dir + "img4_2.png"),
            Pair(self.__dir + "img5_1.png", self.__dir + "img5_2.png"),
            Pair(self.__dir + "img6_1.png", self.__dir + "img6_2.png"),
            Pair(self.__dir + "img7_1.png", self.__dir + "img7_2.png"),
            Pair(self.__dir + "img8_1.png", self.__dir + "img8_2.png"),
            Pair(self.__dir + "img9_1.png", self.__dir + "img9_2.png"),
            Pair(self.__dir + "img10_1.png", self.__dir + "img10_2.png"),
            Pair(self.__dir + "img11_1.png", self.__dir + "img11_2.png"),
            Pair(self.__dir + "img12_1.png", self.__dir + "img12_2.png"),
            Pair(self.__dir + "img13_1.png", self.__dir + "img13_2.png"),
            Pair(self.__dir + "img14_1.png", self.__dir + "img14_2.png"),
            Pair(self.__dir + "img15_1.png", self.__dir + "img15_2.png"),
            Pair(self.__dir + "img16_1.png", self.__dir + "img16_2.png"),
            Pair(self.__dir + "img17_1.png", self.__dir + "img17_2.png"),
        ]

    def getTrainingGroup(self):
        return self.__training_group
