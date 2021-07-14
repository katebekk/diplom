import cv2
from Builders.Utils.Utils import Utils as util


class ImageEditor(object):
    @classmethod
    def find_contours(cls, img):
        # img = cls.blur_image(img, 9)
        img_gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        _, threshold = cv2.threshold(img_gray, 127, 255, cv2.THRESH_BINARY_INV)
        contours, _ = cv2.findContours(threshold, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
        for cnt in contours:
            epsilon = 0.1 * cv2.arcLength(cnt, True)
            approx = cv2.approxPolyDP(cnt, epsilon, True)
            x, y = approx[0][0]
        return contours

    @staticmethod
    def to_gray_scale(img):
        img_gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        return img_gray

    @staticmethod
    def blur_image(img, scale=9):
        img_blur = cv2.medianBlur(img, scale)
        return img_blur

    @staticmethod
    def img_saturation(img):
        img_hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
        saturation = img_hsv[:, :, 1].mean()
        return saturation

    @staticmethod
    def binary_image(img):
        _, img_bin = cv2.threshold(img, 127, 255, cv2.THRESH_BINARY)
        return img_bin

    @staticmethod
    def binary_image_with_param(img):
        param = 127
        saturation = ImageEditor.img_saturation(img)
        if saturation > 80:
            param = 80
        _, img_bin = cv2.threshold(img, param, 255, cv2.THRESH_BINARY)
        return img_bin

    @staticmethod
    def find_drawing(img):
        contours = ImageEditor.find_contours(img)
        # максимальный контур
        c = max(contours, key=cv2.contourArea)
        x, y, w, h = cv2.boundingRect(c)
        drawing = img[y:(y + h), x:(x + w)]
        return drawing

    @staticmethod
    def resize_percent_of_original(img, percent_of_original=100):
        width = int(img.shape[1] * percent_of_original / 100)
        height = int(img.shape[0] * percent_of_original / 100)
        dim = (width, height)

        # resize image
        img = cv2.resize(img, dim, cv2.INTER_AREA)
        return img

    @staticmethod
    def images_to_compared_view(img1, img2):
        img1 = util.read_image_as_array(img1)
        img2 = util.read_image_as_array(img2)

        img1 = ImageEditor.binary_image_with_param(img1)
        img2 = ImageEditor.binary_image_with_param(img2)
        # util.show_image(img2)

        drawing1 = ImageEditor.find_drawing(img1)
        drawing2 = ImageEditor.find_drawing(img2)

        return drawing1, drawing2
