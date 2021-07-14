import cv2
import matplotlib.pyplot as plt
import numpy as np
from skimage.metrics import structural_similarity as ssim
from Builders.SectorParser.SectorParser import SectorParser as sp
from Builders.Utils.Utils import Utils


class ImageComparer(object):
    @classmethod
    def mse(cls, imageA, imageB):
        # the 'Mean Squared Error' between the two images is the
        # sum of the squared difference between the two images;
        # NOTE: the two images must have the same dimension
        err = np.sum((imageA.astype("float") - imageB.astype("float")) ** 2)
        err /= float(imageA.shape[0] * imageA.shape[1])

        # return the MSE, the lower the error, the more "similar"
        # the two images are
        return err

    @classmethod
    def compare_images(cls, imageA, imageB, title):
        # compute the mean squared error and structural similarity
        # index for the images
        m = cls.mse(imageA, imageB)
        s = ssim(imageA, imageB, multichannel=True)
        # setup the figure
        fig = plt.figure(title)
        plt.suptitle("MSE: %.2f, SSIM: %.2f" % (m, s))
        # show first image
        ax = fig.add_subplot(1, 2, 1)
        plt.imshow(imageA, cmap=plt.cm.gray)
        plt.axis("off")
        # show the second image
        ax = fig.add_subplot(1, 2, 2)
        plt.imshow(imageB, cmap=plt.cm.gray)
        plt.axis("off")
        # show the images
        plt.show()


    @staticmethod
    def check_proportions(img1, img2):
        result = True
        height, width = img1.shape[:2]
        proportion1 = height / width
        height, width = img2.shape[:2]
        proportion2 = height / width
        dif = abs(proportion1 - proportion2)
        if dif > 0.15:
            result_msg = "Пропорции рисунка неверны"
            result = False
        else:
            result_msg = "Пропорции верны"
        return result, result_msg

    @staticmethod
    def to_reference_size(reference, learner):
        message = "All alright"
        width = int(reference.shape[1])
        height = int(reference.shape[0])
        dim = (width, height)
        # resize image
        img = cv2.resize(learner, dim, cv2.INTER_AREA)
        return img

    @staticmethod
    def compare_mse(reference, learner):
        result_img = learner
        Utils.show_image(reference)
        coord = sp.img_into_sectors(reference, 5)
        sectors_number = len(coord)
        error_sectors_number = 0
        for i in range(sectors_number-1):
            s = coord[i]
            ref_sect = sp.get_img_sector(reference, coord[i])
            lear_sect = sp.get_img_sector(learner, coord[i])

            # Utils.show_image(ref_sect)
            # Utils.show_image(lear_sect)
            m = ImageComparer.mse(ref_sect, lear_sect)
            if m > 25000:
                cv2.rectangle(result_img, (coord[i][0], coord[i][2]), (coord[i][1], coord[i][3]),
                                                     (255, 0, 0), 5)
                error_sectors_number += 1
        percent = 100 - round(error_sectors_number / sectors_number * 100)
        if percent < 80:
            message = "Рисунок нарисован неправильно"
        elif percent < 100:
            message = "Рисунок нарисован правильно, но есть неточности"
        else:
            message = "Рисунок нарисован правильно"
        return result_img, message , percent

    @staticmethod
    def compare_ssim(reference, learner):
        result_ssim = learner
        ref_coord = ImageComparer.img_into_sectors(reference, 5)
        lear_coord = ImageComparer.img_into_sectors(learner, 5)
        for i in range(len(lear_coord)):
            ref_sect = ImageComparer.get_img_sector(reference, ref_coord[i])
            lear_sect = ImageComparer.get_img_sector(learner, lear_coord[i])
            s = ssim(ref_sect, lear_sect, multichannel=True)
            if s <= 0.66:
                cv2.rectangle(result_ssim, (ref_coord[i][2], ref_coord[i][0]), (ref_coord[i][3], ref_coord[i][1]),
                              (255, 0, 0), 5)
        message = "Ошибки не найдены"
        return result_ssim
