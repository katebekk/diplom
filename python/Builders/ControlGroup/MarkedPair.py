class MarkedPair:
    __expected_result = None
    __similarity = None
    __img1 = None
    __img2 = None

    def __init__(self, similarity, expected_result, img1, img2):
        self.__expected_result = expected_result
        self.__similarity = similarity
        self.__img1 = img1
        self.__img2 = img2

    def getExpectedResult(self):
        return self.__expected_result

    def getSimilarity(self):
        return self.__similarity

    def getImg1(self):
        return self.__img1

    def getImg2(self):
        return self.__img2

