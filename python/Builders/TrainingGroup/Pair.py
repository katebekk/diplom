class Pair:
    __img1 = None
    __img2 = None

    def __init__(self, img1, img2):
        self.__img1 = img1
        self.__img2 = img2

    def getImg1(self):
        return self.__img1

    def getImg2(self):
        return self.__img2
