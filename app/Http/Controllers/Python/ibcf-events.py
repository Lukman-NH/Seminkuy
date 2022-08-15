# Import library
import pandas as pd
import numpy as np
import time
import os
from math import sqrt
from numpy import random
from sklearn.metrics import mean_absolute_error, mean_squared_error


FULL_PATH_RATINGS = os.path.dirname(os.path.dirname(os.path.dirname(
    os.path.dirname(os.path.dirname(__file__))))) + '\storage\\app\public\\assets\ibcf-test\\ratings.csv'


# Clear terminal & ignore "RuntimeWarning: invalid value encountered in true_divide"
os.system('cls||clear')
np.seterr(divide='ignore', invalid='ignore')


# Reading data and define columns
read_start_time = time.time()
df = pd.read_csv(
    FULL_PATH_RATINGS, sep=',')
read_end_time = time.time()


# Total users and travel packages
n_users = df.users_id.max()
n_events = df.events_id.max()


# Converting data to matrix form
mat_start = time.time()
rating = np.zeros((n_users, n_events))
for row in df.itertuples():
    rating[row[1]-1, row[2]-1] = row[3]
mat_end = time.time()


# Train_test_splitting
trainset = np.copy(rating)
testset = np.zeros((n_users, n_events))


# Z for iterate over each row
train_test = time.time()
z = 0
for row in rating:
    nz_in = np.nonzero(row)
    per_20 = int(len(nz_in[0]) * 0.2)
    rand = random.choice(nz_in[0], per_20, replace=False)
    for i in range(per_20):
        testset[z, rand[i]] = rating[z, rand[i]]
        trainset[z, rand[i]] = 0
    z = z + 1
train_test_end = time.time()


# Adjusted cosine similarity calculation
def adjusted_cosine_similarity(train_data):
    start = time.time()
    u_m = train_data.sum(axis=1) / (train_data != 0).sum(axis=1)
    rating_m_sub = np.where(
        (train_data != 0), train_data-u_m[:, None], train_data)
    similarity = np.zeros((n_events, n_events))

    for i in range(n_events):
        print(i)
        for j in range(i, n_events):
            num = 0
            dem1 = 0
            dem2 = 0
            set_c_u = np.where((train_data[:, i] != 0) * (train_data[:, j]))[0]
            for k in set_c_u:
                num = num+rating_m_sub[k][i] * rating_m_sub[k][j]
                dem1 = dem1 + rating_m_sub[k][i]**2
                dem2 = dem2 + rating_m_sub[k][j]**2
                similarity[i, j] = num/sqrt(dem1*dem2 + 10**-12)
    end = time.time() - start

    print("similarity time = ", end)
    return similarity


# Copying below diagonal of similarity matrix
similarity = adjusted_cosine_similarity(trainset)
upp_tr = np.triu(similarity, k=1)
upp_tr = upp_tr.T
similarity = similarity + upp_tr
similarity = np.where((similarity < 0), 0, similarity)


# Prediction
mul = trainset.dot(similarity)
div = np.zeros((n_users, n_events))
stt = time.time()

for i in range(n_users):
    nzi = np.nonzero(trainset[i])
    for j in range(n_events):
        sm = (similarity[j, nzi]).sum()
        div[i, j] = sm
    endd = time.time() - stt
    print(endd)


np.nan_to_num(div, copy=False)
prediction = mul/div
np.nan_to_num(prediction, copy=False)


# save similarity matrix to similarity.csv
FULL_PATH_SIMILARITY = os.path.dirname(os.path.dirname(os.path.dirname(
    os.path.dirname(os.path.dirname(__file__))))) + '\storage\\app\public\\assets\ibcf-test\\similarity.csv'

np.savetxt(FULL_PATH_SIMILARITY, similarity, fmt='%.4f', delimiter='|')


# save prediction matrix to prediction.csv
FULL_PATH_PREDICTION = os.path.dirname(os.path.dirname(os.path.dirname(
    os.path.dirname(os.path.dirname(__file__))))) + '\storage\\app\public\\assets\ibcf-test\\prediction.csv'

np.savetxt(FULL_PATH_PREDICTION, prediction, fmt='%.4f', delimiter='|')
