package com.xemplar.utils.dnrlotto.server.http.client;

import com.xemplar.utils.dnrlotto.server.http.HttpLayerException;

public interface SimpleHttpClient {
	String execute(String reqMethod, String reqPayload) throws HttpLayerException;
	void close();
}