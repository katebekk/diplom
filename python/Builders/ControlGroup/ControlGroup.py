from Builders.ControlGroup.MarkedPair import MarkedPair


class ControlGroup:
    __dir = "src/Images/control_group/"
    __control_group = None

    def __init__(self):
        self.__control_group = [

            MarkedPair(4, True, self.__dir + "4/img1_1.png", self.__dir + "4/img1_2.png"),
            MarkedPair(4, True, self.__dir + "4/img2_1.png", self.__dir + "4/img2_2.png"),
            MarkedPair(4, True, self.__dir + "4/img3_1.png", self.__dir + "4/img3_2.png"),
            MarkedPair(4, True, self.__dir + "4/img4_1.png", self.__dir + "4/img4_2.png"),
            MarkedPair(4, True, self.__dir + "4/img5_1.png", self.__dir + "4/img5_2.png"),
            MarkedPair(4, True, self.__dir + "4/img6_1.png", self.__dir + "4/img6_2.png"),
            MarkedPair(4, True, self.__dir + "4/img7_1.png", self.__dir + "4/img7_2.png"),

            MarkedPair(3, True, self.__dir + "3/img1_1.png", self.__dir + "3/img1_2.png"),
            MarkedPair(3, True, self.__dir + "3/img2_1.png", self.__dir + "3/img2_2.png"),
            MarkedPair(3, True, self.__dir + "3/img3_1.png", self.__dir + "3/img3_2.png"),
            MarkedPair(3, True, self.__dir + "3/img4_1.png", self.__dir + "3/img4_2.png"),
            MarkedPair(3, True, self.__dir + "3/img5_1.png", self.__dir + "3/img5_2.png"),
            MarkedPair(3, True, self.__dir + "3/img6_1.png", self.__dir + "3/img6_2.png"),
            MarkedPair(3, True, self.__dir + "3/img7_1.png", self.__dir + "3/img7_2.png"),
            MarkedPair(3, True, self.__dir + "3/img8_1.png", self.__dir + "3/img8_2.png"),

            MarkedPair(2, False, self.__dir + "2/img1_1.png", self.__dir + "2/img1_2.png"),
            MarkedPair(2, False, self.__dir + "2/img2_1.png", self.__dir + "2/img2_2.png"),
            MarkedPair(2, False, self.__dir + "2/img3_1.png", self.__dir + "2/img3_2.png"),
            MarkedPair(2, False, self.__dir + "2/img4_1.png", self.__dir + "2/img4_2.png"),
            MarkedPair(2, False, self.__dir + "2/img5_1.png", self.__dir + "2/img5_2.png"),
            MarkedPair(2, False, self.__dir + "2/img6_1.png", self.__dir + "2/img6_2.png"),
            MarkedPair(2, False, self.__dir + "2/img7_1.png", self.__dir + "2/img7_2.png"),
            MarkedPair(2, False, self.__dir + "2/img8_1.png", self.__dir + "2/img8_2.png"),

            MarkedPair(1, False, self.__dir + "1/img1_1.png", self.__dir + "1/img1_2.png"),
            MarkedPair(1, False, self.__dir + "1/img2_1.png", self.__dir + "1/img2_2.png"),
            MarkedPair(1, False, self.__dir + "1/img3_1.png", self.__dir + "1/img3_2.png"),
            MarkedPair(1, False, self.__dir + "1/img4_1.png", self.__dir + "1/img4_2.png"),
            MarkedPair(1, False, self.__dir + "1/img5_1.png", self.__dir + "1/img5_2.png"),
            MarkedPair(1, False, self.__dir + "1/img6_1.png", self.__dir + "1/img6_2.png"),
            MarkedPair(1, False, self.__dir + "1/img7_1.png", self.__dir + "1/img7_2.png"),
            MarkedPair(1, False, self.__dir + "1/img8_1.png", self.__dir + "1/img8_2.png"),
            MarkedPair(1, False, self.__dir + "1/img9_1.png", self.__dir + "1/img9_2.png"),
            MarkedPair(1, False, self.__dir + "1/img10_1.png", self.__dir + "1/img10_2.png"),
        ]

    def getControlGroup(self):
        return self.__control_group
